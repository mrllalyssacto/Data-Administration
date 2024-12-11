<?php
include("connect.php");

$creditCardTypeFilter = isset($_GET['creditCardType']) ? $_GET['creditCardType'] : '';
$aircraftTypeFilter = isset($_GET['aircraftType']) ? $_GET['aircraftType'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : '';
$order = isset($_GET['order']) ? $_GET['order'] : '';

$flightQuery = "SELECT * FROM flightlogs";

if ($creditCardTypeFilter != '' || $aircraftTypeFilter != '') {
    $flightQuery .= " WHERE";

    if ($creditCardTypeFilter != '') {
        $flightQuery .= " creditCardType='$creditCardTypeFilter'";
    }

    if ($creditCardTypeFilter != '' && $aircraftTypeFilter != '') {
        $flightQuery .= " AND";
    }

    if ($aircraftTypeFilter != '') {
        $flightQuery .= " aircraftType='$aircraftTypeFilter'";
    }
}

if ($sort) {
    $flightQuery .= " ORDER BY $sort";
    if ($order) {
        $flightQuery .= " $order";
    }
}

$flightResults = executeQuery($flightQuery);

$creditCardTypeQuery = "SELECT DISTINCT(creditCardType) FROM flightlogs";
$airlineResults = executeQuery($creditCardTypeQuery);

$aircraftTypeQuery = "SELECT DISTINCT(aircraftType) FROM flightlogs";
$aircraftTypeResults = executeQuery($aircraftTypeQuery);

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Flight Logs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" href="image/logo.png";>
</head>

<body class="bg-light">
    <div class="container my-5">
        <h1 class="text-center mb-4">Flight Logs</h1>

        <form method="GET">
            <div class="card p-4 mb-4 rounded-5">
                <div class="h6 mb-3">Filter & Sort Options</div>
                <div class="d-flex flex-wrap gap-3 align-items-center">

                    <label for="creditCardType" class="form-label">Credit Card Type</label>
                    <select name="creditCardType" id="creditCardType" class="form-control">
                        <option value="">Any</option>
                        <?php while ($row = mysqli_fetch_assoc($airlineResults)) { ?>
                            <option value="<?php echo $row['creditCardType']; ?>"
                                <?php if ($creditCardTypeFilter == $row['creditCardType']) echo "selected"; ?>>
                                <?php echo $row['creditCardType']; ?>
                            </option>
                        <?php } ?>
                    </select>

                    <label for="aircraftType" class="form-label">Aircraft Type</label>
                    <select name="aircraftType" id="aircraftType" class="form-control">
                        <option value="">Any</option>
                        <?php while ($row = mysqli_fetch_assoc($aircraftTypeResults)) { ?>
                            <option value="<?php echo $row['aircraftType']; ?>"
                                <?php if ($aircraftTypeFilter == $row['aircraftType']) echo "selected"; ?>>
                                <?php echo $row['aircraftType']; ?>
                            </option>
                        <?php } ?>
                    </select>

                    <label for="sort" class="form-label">Sort By</label>
                    <select name="sort" id="sort" class="form-control">
                        <option value="">None</option>
                        <option value="departureDatetime" <?php if ($sort == "departureDatetime") echo "selected"; ?>>
                            Departure DateTime
                        </option>
                        <option value="arrivalDatetime" <?php if ($sort == "arrivalDatetime") echo "selected"; ?>>
                            Arrival DateTime
                        </option>
                        <option value="creditCardType" <?php if ($sort == "creditCardType") echo "selected"; ?>>
                            Credit Card Type
                        </option>
                        <option value="aircraftType" <?php if ($sort == "aircraftType") echo "selected"; ?>>
                            Aircraft Type
                        </option>
                    </select>

                    <label for="order" class="form-label">Order</label>
                    <select name="order" id="order" class="form-control">
                        <option value="ASC" <?php if ($order == "ASC") echo "selected"; ?>>Ascending</option>
                        <option value="DESC" <?php if ($order == "DESC") echo "selected"; ?>>Descending</option>
                    </select>

                    <button class="btn btn-primary mt-2" type="submit">Apply</button>
                </div>
            </div>
        </form>

        <div class="table-responsive">
        <table class="table table-dark table-striped">
            <thead>
                <tr>
                    <th>Flight Number</th>
                    <th>Departure Airport</th>
                    <th>Arrival Airport</th>
                    <th>Departure DateTime</th>
                    <th>Arrival DateTime</th>
                    <th>Flight Duration (Minutes)</th>
                    <th>Airline Name</th>
                    <th>Aircraft Type</th>
                    <th>Passenger Count</th>
                    <th>Ticket Price</th>
                    <th>creditCardNumber</th>
                    <th>creditCardType</th>
                    <th>pilotName</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($flightResults->num_rows > 0) {
                    while ($row = $flightResults->fetch_assoc()) {
                        ?>
                        <tr>
                            <th scope="row"><?php echo $row['flightNumber']; ?></th>
                            <td><?php echo $row['departureAirportCode']; ?></td>
                            <td><?php echo $row['arrivalAirportCode']; ?></td>
                            <td><?php echo $row['departureDatetime']; ?></td>
                            <td><?php echo $row['arrivalDatetime']; ?></td>
                            <td><?php echo $row['flightDurationMinutes']; ?></td>
                            <td><?php echo $row['airlineName']; ?></td>
                            <td><?php echo $row['aircraftType']; ?></td>
                            <td><?php echo $row['passengerCount']; ?></td>
                            <td><?php echo $row['ticketPrice']; ?></td>
                            <td><?php echo $row['creditCardNumber']; ?></td>
                            <td><?php echo $row['creditCardType']; ?></td>
                            <td><?php echo $row['pilotName']; ?></td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="12" class="text-center">No records found</td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>
</html>
