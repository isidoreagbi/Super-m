<header class="app-bar">
    <table width="100%">
        <tr>
            <td>
                <a href="{{ route('home') }}">
                    <b>Home</b>
                </a>
            </td>
            <td class="text-right">
                @if (isset($_COOKIE['clientId']) || isset($client->id))
                    <a href="{{ route('profile.edit', ['id' => $_COOKIE['clientId'] ?? $client->id]) }}">
                        <b>Paramètres</b>
                    </a>
                @endif
            </td>
        </tr>
    </table>
</header>

