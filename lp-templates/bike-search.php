<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>

<!--Hier nochmal genau bei forms bzw. validation auf bootstrap schauen weil nicht ganz richtig und input type date anschauen -->
<div class="container border bg-primary-subtle rounded-2">
    <form class="row mb-2 mt-2 justify-content-center" method="GET">
        <div class="col-md-3">
            <div class="mb-1 mt-1">
                <input type="date" class="form-control" name="abholdatum" placeholder="Hier kommt Text">
            </div>
        </div>
        <div class="col-md-3">
            <div class="mb-1 mt-1">
                <input type="date" class="form-control" name="rueckgabedatum" placeholder="Hier kommt Text">
            </div>
        </div>
        <div class="col-md-3 mb-1 mt-1">
            <select class="form-select" name="marke">
                <option>Alle Marken</option>

                <?php
                require_once(MY_PLUGIN_PATH . 'lp-models/class-brand.php');
                $brands = Brand::getAllBrands();

                foreach ($brands as $brand) {
                    echo '
                    <option>' . $brand->getName() . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="col-md-auto mt-1">
            <button class="btn btn-primary" type="submit">Suchen</button>
        </div>
    </form>
</div>

<div class="container mt-3">
    <div class="row justify-content-center">

        <?php
        require_once(MY_PLUGIN_PATH . 'lp-models/class-bike.php');
        if (isset($_GET['marke']) && $_GET['rueckgabedatum'] == '' && $_GET['abholdatum'] == '' && $_GET['marke'] != 'Alle Marken') {
            $bike_brand = $_GET['marke'];
            $bikes = Bike::getBikesByBrand($bike_brand);
        } else if(isset($_GET['rueckgabedatum']) && $_GET['rueckgabedatum'] != '' && $_GET['abholdatum'] != ''){
            $bikes = Bike::getAllAccessibleBikes($_GET['abholdatum'] ,$_GET['rueckgabedatum']);
        }else {
            $bikes = Bike::getAllBikes();
        }

        //Abrufen von allen Motorrädern aus der Datenbank
        foreach ($bikes as $bike) {
            echo '
        <div class="col-lg-6 g-4 d-flex justify-content-center">
            <div class="card text-bg-light" style="width: 25rem; height: 450px;">
            <div class="rounded-2" style="height: 215px">
            <img class="card-img-top" style="width:100%; height: 100%;" src="data:image/png;base64,' . base64_encode($bike->getBild()) . '" alt="Bike">
            </div>
                <div class="card-body">
                    <h5 class="card-title">' . $bike->getName() . '</h5>
                    <p class="card-text">Preis/Tag: ' . $bike->getPreis() / 100 . ' €</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>';
        }
        ?>
    </div>
</div>