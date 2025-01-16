<?php

namespace App\Http\Controllers\config;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class OneSignalController extends Controller
{

    public function sendNotificationBulk($studentRegIds, $message)
    {

        $client = new Client();
        $response = $client->request('POST', 'https://onesignal.com/api/v1/notifications', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic os_v2_app_j6f52svfqzetzel5gz7j62iy4ildevyro6leavfvojrcsq37nhggcwnesbtyyw35xcg6mqbcybkdyyswzpm774if6ij4gq44spo77ji',
            ],
            'json' => [
                'app_id' => '4f8bdd4a-a586-493c-917d-367e9f6918e2',
                'include_external_user_ids' => $studentRegIds,
                'contents' => [
                    'en' => $message,
                ],
                'large_icon' => 'https://scontent.fcmb2-2.fna.fbcdn.net/v/t39.30808-6/449486186_122101426508389434_1741250721716090312_n.jpg?_nc_cat=102&ccb=1-7&_nc_sid=6ee11a&_nc_eui2=AeGJ3qPt7CMAefl3JvX8oR67yBEszx2QEnvIESzPHZASe9b90j7m0HT4TtWEJCe_D3FI63etIcNIuGgykD7Si74E&_nc_ohc=lYWHHHLnjh0Q7kNvgEl7eRe&_nc_oc=Adh5sqVwlJxEB1gPkYgmjByioI0ITvwmWmS69lPZxaRPBT5NAe-3QJv36nRAc19Shi4&_nc_zt=23&_nc_ht=scontent.fcmb2-2.fna&_nc_gid=AvdaUhlyTJ9JtVp0Dws9DRm&oh=00_AYBWjrikMfSj9CVAWTjXncQxN0ka2wqx-9dNPtSMNu6PmA&oe=678C7DAC',
                'big_picture' => 'https://scontent.fcmb2-2.fna.fbcdn.net/v/t39.30808-6/449486186_122101426508389434_1741250721716090312_n.jpg?_nc_cat=102&ccb=1-7&_nc_sid=6ee11a&_nc_eui2=AeGJ3qPt7CMAefl3JvX8oR67yBEszx2QEnvIESzPHZASe9b90j7m0HT4TtWEJCe_D3FI63etIcNIuGgykD7Si74E&_nc_ohc=lYWHHHLnjh0Q7kNvgEl7eRe&_nc_oc=Adh5sqVwlJxEB1gPkYgmjByioI0ITvwmWmS69lPZxaRPBT5NAe-3QJv36nRAc19Shi4&_nc_zt=23&_nc_ht=scontent.fcmb2-2.fna&_nc_gid=AvdaUhlyTJ9JtVp0Dws9DRm&oh=00_AYBWjrikMfSj9CVAWTjXncQxN0ka2wqx-9dNPtSMNu6PmA&oe=678C7DAC',
                'buttons' => [
                    [
                        'id' => 'id1',
                        'text' => 'Open',
                        'url' => 'com.bmt.studentApp://notification',
                    ],
                ],
            ],
        ]);

        return $response->getBody();
    }

    public function sendNotification($externalUserID, $message)
    {
        $client = new Client();
        $response = $client->request('POST', 'https://onesignal.com/api/v1/notifications', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic os_v2_app_j6f52svfqzetzel5gz7j62iy4ildevyro6leavfvojrcsq37nhggcwnesbtyyw35xcg6mqbcybkdyyswzpm774if6ij4gq44spo77ji',
            ],
            'json' => [
                'app_id' => '4f8bdd4a-a586-493c-917d-367e9f6918e2',
                'include_external_user_ids' => [$externalUserID],
                'contents' => [
                    'en' => $message,
                ],
                'large_icon' => 'https://scontent.fcmb2-2.fna.fbcdn.net/v/t39.30808-6/449486186_122101426508389434_1741250721716090312_n.jpg?_nc_cat=102&ccb=1-7&_nc_sid=6ee11a&_nc_eui2=AeGJ3qPt7CMAefl3JvX8oR67yBEszx2QEnvIESzPHZASe9b90j7m0HT4TtWEJCe_D3FI63etIcNIuGgykD7Si74E&_nc_ohc=lYWHHHLnjh0Q7kNvgEl7eRe&_nc_oc=Adh5sqVwlJxEB1gPkYgmjByioI0ITvwmWmS69lPZxaRPBT5NAe-3QJv36nRAc19Shi4&_nc_zt=23&_nc_ht=scontent.fcmb2-2.fna&_nc_gid=AvdaUhlyTJ9JtVp0Dws9DRm&oh=00_AYBWjrikMfSj9CVAWTjXncQxN0ka2wqx-9dNPtSMNu6PmA&oe=678C7DAC',
                'big_picture' => 'https://scontent.fcmb2-2.fna.fbcdn.net/v/t39.30808-6/449486186_122101426508389434_1741250721716090312_n.jpg?_nc_cat=102&ccb=1-7&_nc_sid=6ee11a&_nc_eui2=AeGJ3qPt7CMAefl3JvX8oR67yBEszx2QEnvIESzPHZASe9b90j7m0HT4TtWEJCe_D3FI63etIcNIuGgykD7Si74E&_nc_ohc=lYWHHHLnjh0Q7kNvgEl7eRe&_nc_oc=Adh5sqVwlJxEB1gPkYgmjByioI0ITvwmWmS69lPZxaRPBT5NAe-3QJv36nRAc19Shi4&_nc_zt=23&_nc_ht=scontent.fcmb2-2.fna&_nc_gid=AvdaUhlyTJ9JtVp0Dws9DRm&oh=00_AYBWjrikMfSj9CVAWTjXncQxN0ka2wqx-9dNPtSMNu6PmA&oe=678C7DAC',
                'buttons' => [
                    [
                        'id' => 'id1',
                        'text' => 'Open',
                        'url' => 'com.bmt.studentApp://notification',
                    ],
                ],
            ],
        ]);

        return $response->getBody();
    }

    public function sendNotificationAPI(Request $request)
    {
        $request->validate([
            'external_user_id' => 'required',
            'message' => 'required',
        ]);

        $externalUserID = $request->external_user_id;
        $message = $request->message;

        $response = $this->sendNotification($externalUserID, $message);

        return response()->json([
            'data' => $response,
        ], 200);
    }


}
