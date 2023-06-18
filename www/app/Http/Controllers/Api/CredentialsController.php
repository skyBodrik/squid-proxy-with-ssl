<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SquidAccessUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class CredentialsController extends Controller
{
    public function getNewCredentials(Request $request): Response
    {
        $password = Str::random(10);

        do {
            $name = $_ENV['SERVER_NAME_PREFIX'] . '_' . Str::random(5);
        } while(!is_null($this->getCredentialsModelByName($name)));

        $user = new SquidAccessUser();
        $user->name = $name;
        $user->password = md5($password);
        $user->fullname = $request->getClientIp();

        $user->save();

        //[protocol://][user:password@]proxyhost[:port]
        $proxyAddr = $_ENV['SERVER_SQUID_HOST'];
        $poxyPortHttps = $_ENV['SERVER_SQUID_PORT_HTTPS'];
        $poxyPortHttp = $_ENV['SERVER_SQUID_PORT_HTTP'];

        $response = [
            'http' => sprintf('http://%s:%s@%s:%s', $user->name, $password, $proxyAddr, $poxyPortHttp),
            'https' => sprintf('https://%s:%s@%s:%s', $user->name, $password, $proxyAddr, $poxyPortHttps),
        ];
        return \response(json_encode($response));
    }

    private function getCredentialsModelByName(string $name): ?SquidAccessUser
    {
        return SquidAccessUser::where('name', '=', $name)->first();
    }

    private function switchEnabledFlagForSquidAccessUser(Request $request, bool $isEnabled): Response
    {
        $receivedName = $request->post('name') ?? $request->get('name') ?? '';
        if (empty($receivedName)) {
            return \response('Invalid or missing parameter "name"', 400);
        }

        $foundCredential = $this->getCredentialsModelByName($receivedName);
        if (is_null($foundCredential)) {
            return \response('Credentials not found', 404);
        }

        $foundCredential->enabled = $isEnabled;
        $foundCredential->save();

        return \response('OK', 200);
    }

    public function disableCredentials(Request $request): Response
    {
        return $this->switchEnabledFlagForSquidAccessUser($request, false);
    }

    public function enableCredentials(Request $request): Response
    {
        return $this->switchEnabledFlagForSquidAccessUser($request, true);
    }
}
