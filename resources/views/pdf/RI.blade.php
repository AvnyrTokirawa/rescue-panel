<!DOCTYPE html>
<html lang="FR">
<head>
    <title>rapport_{{$rapport->id}}.pdf</title>
    <style>
        body{
            display: flex;
            flex-direction: column;
        }

        .card{
            border: #0C2646 2px solid;
            margin-bottom: 20px;
            padding: 0;
            border-radius: 7px;
        }
        .card-head{
            width: 100%;
            border-bottom: #0C2646 dashed 2px;
            margin: 0;
        }
        .card-head h3{
            margin: 5px 5px 5px 15px;
            font-size: 15px;
        }
        .card-content{
            margin: 0;
            padding: 0;
        }
        .card-content p {
            margin: 5px 5px 5px 10px;
            text-indent: 15px;
        }
        .item{
            border-bottom: #0C2646 1px dashed;
        }
        .item p{
            font-size: 18px;
            line-height: 19px;
            margin: 5px 5px 5px 10px;
        }
        .fixedd{
            text-decoration: black underline;
            margin-left: 200px;
            font-weight: 600;
        }
        .fixed{
            text-decoration: black underline;
            margin-left: 10px;
            font-weight: 600;
        }
        .item:last-child{
            border-bottom: none;
        }
        .signature{
            display: flex;
            flex-direction: column;
            height: 100px;
        }

    </style>
</head>
<body>
<table class="bordered" style="table-layout: fixed; width: 100%; margin-bottom: 15px">
    <tr class="font-12" style="width: 90%">
        <td style="width: 60%;"><h1 style=";font-weight: 700;font-family: 'Baloo Thambi 2', monospace;">Rapport d'intervention</h1></td>
        <td style="width: 20%;"><img src="{{public_path('assets/images/'. $rapport->service .'.png')}}" alt="" style="width: 150px; height: 150px; margin-left: 0px"></td>
    </tr>
</table>
<div class="card">
    <div class="card-head">
        <h3>Identification du patient</h3>
    </div>
    <div class="card-content id">
        <div class="item">
            <p><span class="fixed">prénom nom :</span> {{$rapport->GetPatient->name}}</p>
        </div>
        <div class="item">
            <p><span class="fixed">n° de téléphone :</span>{{$rapport->GetPatient->tel}}</p>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-head">
        <h3>Section administrative : </h3>
    </div>
    <div class="card-content sa">
        <div class="item">
            <p><span class="fixed">Date et heure de l'intervention :</span>{{$rapport->started_at}} </p>
        </div>
        <div class="item">
            <p><span class="fixed">Transport :</span>{{$rapport->GetTransport->name}}</p>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-head">
        <h3>Description de la blessure constatée</h3>
    </div>
    <div class="card-content bl">
        <p>{{$rapport->description}}</p>
    </div>
</div>
<div class="card">
    <div class="card-head">
        <h3>Arret total d'activité : </h3>
    </div>
    <div class="card-content ATA">
        <p><span class="fixed">durée :</span>{{ ((isset($rapport->ata) && !is_null("ata") && $rapport->ata !== "") ? $rapport->ata : "pas d'ata" )}} </p>
    </div>
</div>


<div class="card">
    <div class="card-head">
        <h3>Personnel traitant : </h3>
    </div>
    <div class="card-content pi">
        <div class="item">
            <p><span class="fixed">Intervention enregistrée le :</span> {{$rapport->created_at}}</p>
        </div>
        <div class="item">
            <p><span class="fixed">prénom nom :</span> {{$user->name}} ({{$rapport->service}})</p>
        </div>

        <div class="item signature">
            <p><span class="fixed">Signature :</span></p>
            <div class="contents">
                <p style="font-weight: 700;font-family: 'Brush Script MT', monospace;font-size: 25px;margin-top: 20px; margin-left: 50%"> {{$user->name}} </p>
            </div>
        </div>
    </div>
</div>

</body>
</html>

