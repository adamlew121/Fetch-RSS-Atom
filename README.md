# Fetch-RSS-Atom

Program pobiera dane RSS/Atom z podanego linku i zapisuje je do podanego pliku *.csv.

Dostępne są dwa polecenia:

* csv:simple URL PATH - pobieranie z URL danych RSS/Atom i zapisanie ich do pliku PATH.csv określonego w ścieżce PATH. Stare dane z pliku PATH.csv są nadpisane.

* csv:extended URL PATH - pobieranie z URL danych RSS/Atom i dopisanie ich do pliku PATH.csv określonego w ścieżce PATH. Nowe dane dopisane są do starych danych z pliku PATH.csv.

Aby zainstalować aplikację, należy użyć polecenia 'composer update' z katalogu głównego aplikacji zawierającego plik composer.json. Do prawidłowego działania aplikacji wymagana jest instalacja PHP (>= 7.4) i Composer'a.

Przykładowe wywołanie aplikacji: "php src/console.php csv:simple https://blog.nationalgeographic.org/feed/ file.csv"
W przypadku niepodania wymaganych argumentów lub wprowadzenia błędnych argumentów, aplikacja zwróci odpowiedni komunikat i zakończy działanie.
