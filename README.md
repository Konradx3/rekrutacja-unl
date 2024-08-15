## Przed uruchomieniem projektu

Konfiguracja dla pakietu xampp. Ścieżka do pliku ```C:\xampp\apache\conf\extra\httpd-vhosts.conf```.
```apacheconf
## Rekrutacja Konrad Konarski Unlimitech ##

<VirtualHost *:80>
    ServerAdmin konasgpro@gmail.com
    DocumentRoot "C:\xampp\laravel\rekrutacja-konrad-konarski-unlimitech\public"
    ServerName unlimitech.localhost
    ServerAlias www.unlimitech.localhost
    <Directory "C:\xampp\laravel\rekrutacja-konrad-konarski-unlimitech">
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
    ErrorLog "logs/rekrutacja-konrad-konarski-unlimitech.localhost-error.log"
    CustomLog "logs/rekrutacja-konrad-konarski-unlimitech.localhost-access.log" common
</VirtualHost>
```

## Konfiguracja php.ini
- Należy włączyć rozszerzenie soap w php.ini ```extension=soap```

Konfiguracja hosts w windows w pliku ```C:\Windows\System32\drivers\etc```.
```
# Rekrutacja Konrad Konarski Unlimitech
127.0.0.1       unlimitech.localhost
```

- Zapisanie pliku hosts wymaga uprawnień admina.
- Po zapisaniu konfiguracji należy zrestartować xampp'a.
- Pamiętaj aby podać dobrą ścieżkę do katalogu ```xampp\laravel\rekrutacja-konrad-konarski-unlimitech```, nie pomylić z htdocs.

## Po skonfigurowaniu środowiska
Tutaj już standardowo, przechodzimy do katalogu projektu i zaciągamy gita ```git clone https://github.com/Konradx3/rekrutacja-konrad-konarski-unlimitech.git .``` <-- pamiętaj o kropce, w przeciwnym razie stworzy dodatkowy katalog.

Przechodzimy do terminala i wykonujemy komendę ```composer install```.

W tym miejscu strona powinna się uruchomić.

## Testy
Testy można uruchomić komendą
```
php artisan test
```
