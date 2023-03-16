# Leiverpress

**ToDo:** 

- Interface mit CRUD-Methoden in lp-models erstellen und Domänen-Klassen implementieren lassen. 
- ~~Logik für den Suchfilter erweitern (Datum und Marke gleichzeitig suchen soll möglich sein -> momentan funktioniert nur nach Marken suchen oder nach Datum mit allen Motorrädern)~~ ✅ _16.03.2023 CS_
- Das erstellen von Equipment (Handschuhe, Helme) -> Domänen-Klasse, Datenbank-Tabelle, Mockdaten
- Das erstellen eines richtigen UML-Diagramms, damit wir wissen wie unsere Datenbank aussehen muss (momentan hab ich nur die wichtigsten Sachen in den Domänen-Klassen und in der DB hinterlegt)
- Eine View erstellen (wenn man ein Motorrad anklickt soll eine Ansicht mit Details von diesem Mottorad erscheinen)
- Logik: Rückgabedatum darf nicht vor Abholdatum liegen
- SQL Statements mit %s absichern (siehe Beispiel class-brand getBrandIdByName)
- Weitere Ideen für dieses Plugin

## Workflow

Den Ordner **leiverpress** lokal, zum Beispiel im Diplomarbeiten Ordner pullen (mit GIT -> Remote-GIT-Ordner). Den Remote-GIT-Ordner nicht mehr bearbeiten! Macht euch eine Kopie vom Ordner und tut diesen zum Beispiel in: XAMPP/htdocs/roadtrip/wp-content/plugins/ rein. Haut den **.git** Ordner aus der geraden erstellten Kopie raus, um lokal mit dem Plugin über Xampp zu arbeiten. Auf dieser Kopie werden nun Veränderungen gemacht. Seit ihr mit der Bearbeitung fertig könnt ihr einzelne Files oder Code-Schnipsel in den Remote-GIT-Ordner einfügen. Anschließend bitte pushen mit aussagekräftigem Commit-Kommentar (Alles auf der Main-Branch).

Um immer auf der aktuellsten Version zu arbeiten müssen wir ständig den Remote-GIT-Ordner neu pullen und wieder eine Kopie in das htdocs Verzeichnis einfügen (ist ein wenig umständlich aber mit Branches arbeiten ist komplex aber leicht bzw. umgekehrt). 

Wir müssen gut miteinander kommunizieren, wer wann etwas macht. So können wir immer sicher sein, dass wir an der aktuellsten Version arbeiten. 

Vielen Dank für das Durchlesen und jetzt FW!

## Plugin Struktur

Im **leiverpress** Ordner befindet sich das File **class-leiverpress.php**, dort wird das Plugin quasi aktiviert. Der anfängliche Kommentarbereich wird in Wordpress im Admin-Panel angezeigt (Plugin Name, Plugin Version, Plugin Beschreibung). Danach folgen im Code Sicherheitsmaßnahmen und zum Abschluss die Leiverpress Klasse. Im Konstruktor werden 2 konstante Variablen definiert, diese sind im ganzen Ordner des leiverpress-Plugins verfügbar. `MY_PLUGIN_PATH` ist der Pfad des Files`class-leiverpress.php` und `MY_PLUGIN_FILE` ist der Pfad **inklusive** des Files `class-leiverpress.php`.  Die Anschrift `__FILE__` kann im gesamten Ordner genutzt werden und entspricht immer dem Pfad inklusive dem jeweiligen File in dem man sich befindet. Mit der Funktion `initialize()` fügt die Klasse verschiedene Abhängigkeiten aus. Hier wird unser Code geladen bzw. initialisiert. 

Das **index.php**  File dient zur Sicherheit, so kann niemand über den gesamten Pfad an unser Plugin gelangen. 

Der Ordner **vendor** und die Files mit der Anschrift **composer** gehören zum Composer-Tool. Dieses kann lokal auf dem PC heruntergeladen werden (mit diesem Tool können Dependencies oder Libraries hinzugefügt werden), bezüglich des Codes verändert er jedoch im Moment nichts.

Im Ordner **lp-data** befinden sich nur die JSON Files zum erstellen von Mockdaten in die Datenbank, sowie die Bilder der Mockdaten.

Im Ordner **lp-database** befindet sich der Code zum Erstellen von den benötigten Tabellen. Die Funktion `<irgendeinName>_install()` erstellt die Datenbank und die Funktion `<irgendeinName>_install_data()` fügt Daten eines Arrays of Objects in die Datenbank ein. Die letzten zwei Funktionen sind Wordpress spezifische Hooks -> `register_activation_hook(File des Plugins, name der Funktion/Methode)`. Diese führt dann die bestimmte Methode aus. Alle drei Dateien sind im **class-leiverpress.php** File in der Methode `initialize()` vertreten und werden somit beim aktivieren des Plugins in Wordpress getriggert. Ist die Datenbank einmal angelegt so kann man entweder alle `register_activation_hook`'s aus kommentieren oder man kommentiert bei der `initialize()` Methode die include's aus (wie man will). 

Im Ordner **lp-includes** werden sich alle Files zum Ausgeben von Content befinden (Muss sich ebenfalls in der Methode `intialize()` im Ausgangs File befinden). In diesem Fall unser Filter für Roadtrip. Das File **bike-search.php** benutzt wiederum das Template mit dem selben Namen (bike-search.php), dieses befindet sich im Ordner **lp-templates**. Im Templates Ordner wird dann das entsprechende HTML geschrieben mit zusätzlichen PHP-Methoden. Im Includes-Ordner sollten sich demnach alle entsprechenden Files mit beigefügten **shortcodes** zum Anzeigen von Content befinden. (Die Funktion `add_action...` in bike-search.php macht noch nichts, da habe ich mit composer etwas versucht).

Im Ordner **lp-models** werden sich unsere Domänen-Klassen befinden. Es wird hier auch ein Interface noch zu schreiben sein, mit entsprechenden CRUD-Methoden. Dieses Interface wird dann von allen (wenn gebraucht) Domänen-Klassen implementiert. 

Im Ordner **lp-templates** die HTML-Schnipsel geschrieben und für den Ordner **lp-includes** zur Verfügung gestellt. 

## Plugin aktivieren

Den Plugin Ordner in: xampp/htdocs/derNameDerWordpressSeite/wp-content/plugins rein kopieren. In Wordpress unter wp-admin anmelden und unter den Reiter installierte Plugins aktivieren. Ist die `register_activation_hook` nicht aus kommentiert so werden durch das aktivieren des Plugins alle Datenbank-Tabellen erstellt und mit Mockdaten gefüllt. 

Bei jeder Wordpress spezifischen Funktion wie zum Beispiel `register_activation_hook` ist es immer sinnvoll das Plugin zu de- und aktivieren. Dabei aber achten ob ihr `register_activation_hook` aus kommentiert habt, damit nicht immer die gleichen Mockdaten in die Datenbank kommen.