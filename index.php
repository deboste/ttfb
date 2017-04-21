<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TTFB - Claranet</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/jszip-3.1.3/pdfmake-0.1.27/b-1.3.1/b-flash-1.3.1/b-html5-1.3.1/cr-1.3.3/r-2.1.1/sc-1.4.2/datatables.min.css"/>
</head>
<body>

<div class="container" role="main">
    <div class="page-header">
        <h1>Benchmark / BFM-IPLabel</h1>
    </div>
    <div class="form-group">
        <label for="comment">Noms de domaines (1 par ligne) :</label>
        <textarea class="form-control" rows="5" id="ndd" name="ndd" required="required"></textarea>
    </div>
    <button type="button" class="btn btn-primary" id="check" name="check">Check</button>
    <button type="button" class="btn btn-warning" id="reset" name="reset">Reset</button>
    <br><br>
    <table id="table_results">
        <thead>
        <tr>
            <th>ndd</th>
            <th>url</th>
            <th>ttfb</th>
            <th>host</th>
            <th>dns</th>
            <th>ttl</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script type="text/javascript" src="js/spin.min.js"></script>
<script type="text/javascript" src="js/jquery.spin.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs/jszip-3.1.3/pdfmake-0.1.27/b-1.3.1/b-flash-1.3.1/b-html5-1.3.1/cr-1.3.3/r-2.1.1/sc-1.4.2/datatables.min.js"></script>
<script type="text/javascript" src="js/client.js"></script>
</body>
</html>