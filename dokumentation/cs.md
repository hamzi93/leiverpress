# Dokumentation leiverpress CS

## 16.03.2023 (~1,5h)
Meine Aufgabe war es, die schon bestehende Filterfunktion zu erweitern.

Vorher konnte man nach Marken bzw. nach einem gewissen Zeitraum aller Motorräder suchen.

Nun kann man ebenfalls gezielt nach einer bervorzugten Motorradmarke in einem gewissen Zeitraum suchen.

Ebenfalls habe ich implementiert, dass die vom Nutzer ausgewählten Werte nach absenden des Formulars weiterhin bestehen bleiben. Also die gewählten Daten in den "date"-Feldern und die gewählte Marke als gewählte Option im Dropdown.


## Bearbeitete Klassen / Methoden:

- Klasse: lp-templates/bike-search.php
- Bearbeitete Codestelle:

```php
else if (isset($_GET['rueckgabedatum']) && $_GET['rueckgabedatum'] != '' && $_GET['abholdatum'] != '' && $_GET['marke'] && $_GET['marke'] != 'Alle Marken') {
            try {
                // Erhalten der Bike-ID in Bezug auf den Namen der Marke
                $bike_id = Brand::getBrandIdByName($_GET['marke']);
                $bikes = Bike::getAllAccessibleBikesByBrand($_GET['abholdatum'], $_GET['rueckgabedatum'], $bike_id);
            } catch (Exception $e) {
                echo $e->getMessage();
            }
```

- Kommentar: Hier sind zwei von mir neu erstellte Funktionen zu erkennen. Einerseits die "getBrandIdByName", andererseits die "getAllAccessibleBikesByBrand". Erstere gibt mir die ID einer Marke zurück, nachdem ich ihr den Markennamen gegeben habe. Die zweite Funktion nimmt diese Marken-ID auf und verarbeitet diese weiter.

---

- Klasse: lp-models/class-brand.php
- Bearbeitete Codestelle:

```php
    public static function getBrandIdByName($brand_name) {
        global $wpdb;
        $tableName = $wpdb->prefix . 'brand';
    
        // Holt sich die ID der Marke nach dem Namen des Bikes raus. (Abgesichert durch %s)
        $query = $wpdb->prepare("SELECT brand_id FROM $tableName WHERE brand_name = %s", $brand_name);
    
        $brand = $wpdb->get_results($query);
    
        if (!empty($brand)) {
            return intval($brand[0]->brand_id);
        } else {
            throw new Exception("Die gewünschte Marke konnte nicht gefunden werden!");
        }
    }
```

- Kommentar: Hier nimmt die Funktion den Markennamen als Parameter auf und gibt die entsprechende Marken-ID zurück. Mit %s wurde das Statement gegen SQL-Injections abgesichert.

---

- Klasse: lp-models/class-bike.php
- Bearbeitete Codestelle:

```php
public static function getAllAccessibleBikesByBrand($abholdatum, $rueckgabedatum, $brandId)
    {
        global $wpdb;

        $tableName = $wpdb->prefix . 'bike';
        $forgeinTableName = $wpdb->prefix . 'booking';

        $sql = $wpdb->get_results
        ("SELECT *
            FROM $tableName as bikes
            WHERE bikes.bike_id NOT IN (
            SELECT bike_id
            FROM $forgeinTableName as bookings
            WHERE ((booking_abholdatum BETWEEN '$abholdatum' AND '$rueckgabedatum')
                OR (booking_rueckgabedatum BETWEEN '$abholdatum' AND '$rueckgabedatum')
                OR ('$abholdatum' BETWEEN booking_abholdatum AND booking_rueckgabedatum)
                OR ('$rueckgabedatum' BETWEEN booking_abholdatum AND booking_rueckgabedatum))) AND bikes.brand_id = '$brandId'"
        );
        $bikesCollection = array();
        foreach ($sql as $bike) {
            $bikesCollection[] = new Bike($bike->bike_id, $bike->bike_name, $bike->bike_preis, $bike->bike_rabatt, $bike->bike_bild, $bike->brand_id);
        }
        return $bikesCollection;
    }
```

- Kommentar: Diese Funktion unterscheided sich zur Funktion "getAllAccessibleBikes" nur darin, dass sie als Parameter die Marken-ID benötigt und diese im SQL-Statement verwendet. Mittels einem AND und dieser ID wird die Suche weiter eingegrenzt und es kann nach Marken gefiltert werden.

---

- Klasse: lp-templates/bike-search.php
- Bearbeitete Codestelle:

```php
<?php
    require_once(MY_PLUGIN_PATH . 'lp-models/class-brand.php');
    $brands = Brand::getAllBrands();

    foreach ($brands as $brand) {
        $selected = '';
        if (isset($_GET['marke']) && $_GET['marke'] == $brand->getName()) {
            $selected = 'selected';
        }
        echo '<option ' . $selected . '>' . $brand->getName() . '</option>';
    }
?>
```

```html
<input type="date" class="form-control" name="abholdatum" placeholder="Hier kommt Text" value="<?php echo isset($_GET['abholdatum']) ? $_GET['abholdatum'] : '' ?>">
```

```html
<input type="date" class="form-control" name="rueckgabedatum" placeholder="Hier kommt Text" value="<?php echo isset($_GET['rueckgabedatum']) ? $_GET['rueckgabedatum'] : '' ?>">
```

- Kommentar: Im ersten Codeschnippsel wird die vom Nutzer ausgewählte Motorradmarke nach absenden des Formulars wieder als Standardwert in das Dropdown geladen. Bei den anderen beiden Codeschnippseln sieht man, dass die vom Nutzer ausgewählten Daten ebenfalls nach absenden des Formulars erneut in den Date-Picker geladen werden.