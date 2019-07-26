<?php

namespace App\Console\Commands\Feed;

use App\Enums\PropertyMediaType;
use App\Models\Property;
use App\Models\City;
use App\Models\PropertyMedia;
use App\Services\HomeBuzz as HomeBuzzProvider;
use Exception;
use Illuminate\Console\Command;
use Log;
use Carbon\Carbon;
use Storage;
use App\Enums\PropertyStatus;
use Geocoder\Laravel\Facades\Geocoder;
use SimpleXMLElement;

class HomeBuzz extends Command
{
    private $propertyType = [
        'Home'              => 2,
        'House'             => 2,
        'Townhouse'         => 12,
        'Duplex'            => 4,
        'Apartment'         => 1,
        'Condo'             => 3,
        'Basement'          => 20,
        'Furnished'         => 1, /* todo if type furnished add feature - furnished */
        'Single'            => 19, // just room
        'Rental'            => 20,
        'Cottage/cabin'     => 2,
        'Manufactured home' => 17,
        'Loft'              => 19,
    ];

    protected $signature = 'feed:homebuzz';

    protected $description = 'Implements syncing homebuzz data feed';

    public function handle(HomeBuzzProvider $homeBuzz): void
    {
        $this->info('Starting sync:');
        $properties = $this->requestProperty($homeBuzz);

        // get all id that we have
        $homeBuzzPropertyIDS = Property::where('initiator->name', 'homebuzz')
            ->select('initiator->id AS id')->pluck('id')->toArray();
        // ids that they have
        $receivedPropertyIDs = [];
        foreach ($properties->Listing as $property) {
            $receivedPropertyIDs[] = (int)$property->ID;
        }

        // get new ids to Process
        $newIDs = array_diff($receivedPropertyIDs, $homeBuzzPropertyIDS);
        // get ids that have to be deleted
        $deleteIDs = array_diff($homeBuzzPropertyIDS, $receivedPropertyIDs);
        $this->info('Property id to delete: ' . print_r($deleteIDs, true));
        Log::channel('homebuzz')->debug('Property id to delete ', ['object' => $deleteIDs]);
        if ($deleteIDs) {
            $prList = Property::whereIn('initiator->id', $deleteIDs)->get(['id']);
            $this->info('Property id to delete FOUNDED: ' . print_r($prList, true));
            foreach ($prList as $pr) {
                Log::channel('homebuzz')->debug('22 Property id to delete ' . $pr->id);
                $picture = PropertyMedia::where('property_id', $pr->id)->get(['path']);
                if ($picture) {
                    foreach ($picture as $p) {
                        Log::channel('homebuzz')->debug($p->path);
                        $this->removeFile($p->path);
                        $p->delete();
                    }
                }
                $pr->delete();
            }
        }

        foreach ($properties->Listing as $externalProperty) {
            $id = (int)$externalProperty->ID;
            // if it is property that we have, then skip it
            if (!in_array($id, $newIDs, true)) {
                continue;
            }

            $this->info('Processing new id: ' . $id);
            Log::channel('homebuzz')->info('Processing new id: ' . $id);

            $city = City::findByStateCode($externalProperty->State)
                ->findByCountryCode($externalProperty->Country)
                ->where('city.name', $externalProperty->City)
                ->get('city.id')->first();

//            dd($city);
//            $this->info('Property: ' . print_r($externalProperty, true));
//            $this->info('City: ' . print_r($city, true));

            if (null === $city) {
                $message = 'Location not found: Country - ' . $externalProperty->Country;
                $message .= ' State - ' . $externalProperty->State . ' City - ' . $externalProperty->City;
                $this->error($message);
                Log::channel('homebuzz')->error($message);
                throw new Exception();
            }

            // todo add user
            // create user or get his id
//            $user = EcomOldUser::where('foreign_id', '=', 'homebuzz-' . $property->ContactPhone)->first();
//            if (!$user) {
//                $user             = new EcomOldUser();
//                $user->owner_id   = 1054668; // is id in main user homebuzz in our user table, created manually
//                $user->partner_id = 1054668; // to load image our partner
//                $user->phone      = $property->ContactPhone;
//                $user->email      = $property->ContactEmail;
//                $user->verified   = true;
//                $user->show_phone = true;
//                $user->firstname  = 'Property';
//                $user->lastname   = 'Manager';
//                $user->group_id   = 1100000;
//                $user->city_id    = $location->loc_id_level5;
//                $user->password   = 'blank' . $property->ContactPhone;
//                $user->username   = 'homebuzz-' . $property->ContactName;
//                $user->foreign_id = 'homebuzz-' . $property->ContactPhone;
//                $user->save();
//            }

            $property = new Property();

            // location
            try {
                $res           = Geocoder::geocode("$externalProperty->StreetAddress, $externalProperty->State, $externalProperty->Country, $externalProperty->PostalCode")->get()->first();
                $property->lat = $res->getCoordinates()->getLatitude();
                $property->lng = $res->getCoordinates()->getLongitude();
            } catch (Exception $e) {
                $addr    = "$externalProperty->StreetAddress, $externalProperty->State, $externalProperty->Country, $externalProperty->PostalCode";
                $message = 'Geocoding fail :' . $e->getMessage() . ' Addr ' . $addr;
                $this->error($message);
                Log::channel('homebuzz')->error($message);
                continue;
            }
            $property->city_id = $city->id;

            /* todo change hardcode */
            $property->user_id = 1;

            $property->status = PropertyStatus::AVAILABLE;
            if ($property->DateAvailable) {
                $property->available_at = Carbon::createFromFormat('d/m/Y', $externalProperty->DateAvailable);
            }

            $property->title            = $externalProperty->StreetAddress;
            $property->price            = $externalProperty->Price;
            $property->bedrooms         = $externalProperty->Bedrooms == 'Studio' ? 0 : $externalProperty->Bedrooms;
            $property->bathrooms        = $externalProperty->FullBathrooms + ($externalProperty->PartialBathrooms / 2);
            $property->property_type_id = $this->propertyType[(string)$externalProperty->PropertyType];
            $property->address          = $externalProperty->StreetAddress;
            $property->postcode         = $externalProperty->PostalCode;
            $property->description      = $externalProperty->Description;

            if (!empty($externalProperty->SquareFootage)) {
                $property->square_feet = str_replace(',', '', $externalProperty->SquareFootage);
            }

            $property->initiator = [
                'id'   => $id,
                'name' => 'homebuzz',
                'url'  => (string)$externalProperty->OriginalURL
            ];
//            $ecomOldTable->apartment_buildingid = ;

            $property->pets = false;
            if ($externalProperty->SmallDogsAllowed == 'True' ||
                $externalProperty->LargeDogsAllowed == 'True' ||
                $externalProperty->CatsAllowed == 'True') {
                $property->pets = true;
            }

            // Amenities
//            $settings = [];
//            foreach ($property->Amenities as $amenity) {
//                $amenity = $amenity->Amenity;
//                if ($amenity === 'Dishwasher') {
//                    $ecomOldTable->dishwasher = true;
//                } elseif ($amenity === 'No Smoking') {
//                    $ecomOldTable->smoking = false;
//                } elseif ($amenity === 'No Pets') {
//                    $ecomOldTable->pets = false;
//                } elseif ($amenity === 'Smoke-Free') {
//                    $ecomOldTable->smoking = true;
//                } elseif ($amenity === 'Fridge') {
//                    $ecomOldTable->fridgestove = true;
//                } elseif ($amenity === 'Balcony') {
//                    $ecomOldTable->balcony = true;
//                } elseif ($amenity === 'Storage Locker') {
//                    $ecomOldTable->storageroom = true;
//                } elseif ($amenity === 'Elevators') {
//                    $ecomOldTable->elevator = true;
//                } elseif ($amenity === 'Stove') {
//                    $ecomOldTable->stove = true;
//                } elseif ($amenity === 'Garage') {
//                    $ecomOldTable->secured_garage = true;
//                } elseif ($amenity === 'Parking') {
//                    $ecomOldTable->parking = true;
//                } elseif ($amenity === 'Unfurnished') {
//                    $ecomOldTable->furnished = false;
//                } elseif ($amenity === 'Pool') {
//                    $ecomOldTable->pool = true;
//                } elseif ($amenity === 'Playground') {
//                    $ecomOldTable->playground = true;
//                } elseif ($amenity === 'Security Guard') {
//                    $ecomOldTable->security = true;
//                } elseif ($amenity === 'Microwave') {
//                    $ecomOldTable->microwave = true;
//                // others
//                } else {
//                    $settings['amenities'][] = $amenity;
//                }
//            }
//            $ecomOldTable->settings = json_encode($settings);

            $property->save();

            $pictureExists = PropertyMedia::where('property_id', $property->id)->first();
            if (!$pictureExists) {
                $pictures = null;
                $i        = 0;
                foreach ($externalProperty->Photos as $img) {
                    $media = new PropertyMedia();

                    if ($i === 0) {
                        $media->is_primary = true;
                    }
                    $media->property_id = $property->id;
                    $media->position    = $i++;
                    $media->path        = $this->downloadPicture(
                        (string)$img->Photo->URL,
                        '/property/homebuzz/' . Carbon::now()->year . '/' . Carbon::now()->month . '/' . $property->id . '/'
                    );
                    $media->is_local    = true;
                    $media->type        = PropertyMediaType::IMG;
                    $timestamp = Carbon::now();
                    $media->created_at = $timestamp;
                    $media->updated_at = $timestamp;

                    // if file not fetched or missing on the server skip it
                    if ($media->path === null) {
                        continue;
                    }

                    $pictures[] = $media->attributesToArray();
                }

                if (is_array($pictures)) {
                    PropertyMedia::insert($pictures);
                }
            }
        }
    }


    /**
     * Fetch xml data from homeBuzz
     *
     * @param HomeBuzzProvider $homeBuzz
     *
     * @return SimpleXMLElement
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function requestProperty(HomeBuzzProvider $homeBuzz): SimpleXMLElement
    {
        $res = $homeBuzz->client->request('GET', '/feed/padmapper/?authKey=' . config('app.homebuzz_api_key'));

        if ($res->getStatusCode() !== 200) {
            $message = 'Status code: ' . $res->getStatusCode() . ' Body: ' . $res->getBody();
            Log::channel('homebuzz')->error($message);
            throw new Exception($message);
        }

        return simplexml_load_string($res->getBody());
    }

    /**
     * @param $url
     * @param $dir
     *
     * @return string|null
     */
    public function downloadPicture($url, $dir): ?string
    {
        try {
            $fileSource = file_get_contents($url);
            $fileName   = basename($url);
            Storage::disk('local')->put($dir . $fileName, $fileSource);

            return $dir . $fileName;
        } catch (Exception $e) {
            Log::channel('homebuzz')->info('Img Url ' . $url . ' File missing: ' . $e->getMessage());
        }

        return null;
    }

    private function removeFile(string $location): bool
    {
        if (Storage::disk('local')->exists($location)) {
            return Storage::disk('local')->delete($location);
        }

        return false;
    }
}
