# Dokumentation leiverpress AH

## 03.04 - 06.04.23 (~6h)

Die gesamte Struktur der Klassen wurde dem UML-Diagramm angepasst. Zusätzlich wurden die passenden Dummy-Daten für das Einfügen in die Datenbank, sowie die passenden `-database.php`-Files erstellt (zum Testen).  

Somit haben wir nachdem aktivieren des Plugins alle wichtigen Tabellen in der DB zur Verfügung. Dabei kann man die Klassen `Clothing`, `ClothingDetail` und `ClothingCategory` vernachlässigen, da wahrscheinlich nicht mit aufgenommen wird. Grund: Der Kunde soll selber die verschiedenen Bekleidungsgegenstände in WordPress stellen können (als Seite, oder wir stellen ihm die Option selbst zur Verfügung in der linken Leiste von WordPress -> auch über das Plugin möglich). Sollte ein Kunde Bekleidung reservieren, dann wird nur ein Häkchen angeklickt und 50€ zur Bestellung hinzugefügt. 

## Bearbeitung

Neuerungen:

- ganz neuer `lp-data` Ordner mit passenden Fotos und JSON-Files
- neu überarbeiteter `lp-models` Ordner mit abgestimmten Klassen
- neu überarbeiteter `lp-database` Ordner mit angepassten Methoden für das erstellen von Tabellen in der DB und das Einfügen von JSON-Daten
- ganz neuer `lp-functions` Ordner für Methoden die häufig verwendet werden und nicht einer gewissen Klasse untergeordnet werden können

Alle Klassen sind ähnlich aufgebaut -> Alle haben Getter und Setter und eine Methode für das Auslesen von JSON-Files. 

Klasse `Customer` anstatt von User, weil jeder `Customer` gleich behandelt wird, egal ob angemeldeter User oder nicht. Das heißt, dass jeder Benutzer der ein Bike reservieren/bestellen möchte einen Bogen ausfüllen muss. Mit diesen Daten wird ein Customer erstellt (dies geschieht natürlich erst beim anklicken im Warenkorb von entweder *Jetzt Zahlen* oder *Jetzt reservieren*).

Bei `Booking` und `BookingDetail` sind die Konstrukteure anders. Der Grund ist die flexiblere Arbeit mit den Klassen, da diese erstellt werden müssen wenn ein Kunde ein Bike in den Warenkorb tut. Hier können nicht alle Infos sofort erstellt werden -> wie zum Beispiel der `Customer`, oder das Bestelldatum in der Klasse `Booking`, oder der endgültige Preis der gesamten Buchung, der erst berechnet werden muss. 

**!ACHTUNG!** Es sind teilweise noch SQL-Statements in einigen `models-Klassen` zu finden, diese sind natürlich so nicht mehr nützlich, jedoch ist der Aufbau der SQL-Statements immer noch richtig und kann nach Überarbeitung wieder benutzt werden. Der Plan ist, ein `lp-repos` und ein `lp-services` Ordner zu erstellen und dort alle SQL-Statements auszulagern -> Hier können die Vorlagen (SQL-Statements) aus den `models-Klassen` verwendet werden, deshalb habe ich sie noch drinnen gelassen. 
