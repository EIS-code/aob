<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title></title>
        <style>
            table {
                font-family: arial, sans-serif;
                border-collapse: collapse;
                width: 100%;
            }

            td, th {
                border: 1px solid #dddddd;
                text-align: left;
                padding: 8px;
            }

            tr:nth-child(even) {
                background-color: #dddddd;
            }
        </style>
    </head>
    <body>
        <table>
            <tr>
                <td><b>Nome Completo / Full Name:</b></td>
                <td>{{$data['full_name']}}</td>
            </tr>
            <tr>
                <td><b>Data de Nascimento / Date of Birth:</b></td>
                <td>{{$data['dob']}}</td>
            </tr>
            <tr>
                <td><b>Cartão de Cidadão / ID / Passport Number:</b></td>
                <td>{{$data['passport_number']}}</td>
            </tr>
            <tr>
                <td><b>Cartão de Cidadão / ID / Passport Expiration date:</b></td>
                <td>{{$data['passport_expired_date']}}</td>
            </tr>
            <tr>
                <td><b>NIF (Número de Contribuinte) / Tax payer number:</b><td>
                <td>{{$data['nif']}}</td>
            </tr>
            <tr>
                <td><b>NISS ( Segurança Social) / Social Security Number:</b></td>
                <td>{{$data['niss']}}</td>
            </tr>
            <tr>
                <td><b>NISS ( Segurança Social) / Social Security Number:</b></td>
                <?php
                if ($data['niss_type'] == '0') {
                    $type = 'Single';
                } else if ($data['niss_type'] == '1') {
                    $type = 'Married';
                } else if ($data['niss_type'] == '2') {
                    $type = 'Divorced';
                } else if ($data['niss_type'] == '3') {
                    $type = 'Widowed';
                } else if ($data['niss_type'] == '4') {
                    $type = 'Separated';
                }
                ?>
                <td>{{$type}}</td>
            </tr> 
            <tr>
                <td><b>Número de Dependentes / Number of dependents:</b></td>
                <td>{{$data['total_dependents']}}</td>
            </tr>
            <tr>
                <td><b>NIB / IBAN:</b></td>
                <td>{{$data['iban']}}</td>
            </tr>
            <tr>
                <td><b>Morada / Address:</b></td>
                <td>{{$data['address']}}</td>
            </tr>
            <tr>
                <td><b>Contacto Telefônico / Contact Number:</b></td>
                <td>{{$data['contact_no']}}</td>
            </tr>
            <tr>
                <td><b>Endereço de E-Mail / E-mail address:</b></td>
                <td>{{$data['email']}}</td>
            </tr>
            <tr>
                <td><b>Nome para contacto de emergência / Emergency Contact Name:</b></td>
                <td>{{$data['emergency_contact_name']}}</td>
            </tr>
            <tr>
                <td><b>Telefone de Contacto de Emergência / Emergency Contact Details:</b></td>
                <td>{{$data['emergency_contact_details']}}</td>
            </tr>
        </table>
        <div style="page-break-before: always;">
            <table>
                <tr>
                    <td><b>Last employer</b></td>
                    <td>{{$data['last_employer']}}</td>
                </tr>
                <tr>
                    <td><b>Designation held</b></td>
                    <td>{{$data['designation']}}</td>
                </tr>
                <tr><
                    <td>b>years/months worked in that company</b></td>
                    <td>{{$data['total_work_time']}}</td>
                </tr>
                <tr>
                    <td><b>Reason for leaving</b></td>
                    <td>{{$data['reason_of_leaving']}}</td>
                </tr>
                <tr>
                    <td><b>IBAN proof (PDF)</b></td>
                    <td>{{$data['iban_proof']}}</td>
                </tr>
                <tr>
                    <td><b>ID card / if not valid, proof of renewal by the embassy (PDF)</b></td>
                    <td>{{$data['card_proof']}}</td>
                </tr>
                <tr>
                    <td><b>Residence proof</b></td>
                    <td>{{$data['residence_proof']}}</td>
                </tr>
                <tr>
                    <td><b>Educational documents</b></td>
                    <td>{{$data['educational_proof']}}</td>
                </tr>
                <tr>
                    <td><b>local references</b></td>
                    <td>{{$data['local_proof']}}</td>
                </tr>
            </table>
        </div>
    </body>
</html>