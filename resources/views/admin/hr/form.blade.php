<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Hiring</title>
        <link href="{{SYSTEM_SITE_URL}}assets/hr/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="{{SYSTEM_SITE_URL}}assets/hr/css/style.css" rel="stylesheet" type="text/css">
        <link href="{{SYSTEM_SITE_URL}}assets/hr/css/bootstrap-datepicker.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" crossorigin="anonymous" />
    </head>
    <body>
        @if(Session::has('fail_msg'))
        <div class="row alert alert-danger text text-center">
            {{Session::get('fail_msg')}}
        </div>
        @else
        @if($errors->any())
        {!! implode('', $errors->all('<div class="row alert alert-danger text text-center">:message</div>')) !!}
        @endif
        @endif
        <div class="form-main">
            <div class="form-inner">
                <div class="form-header">
                    <h2>New Hire Form</h2>
                    <p>Hiring new employees comes with some unavoidable paperwork. The below information is required so that Cluster can proceed with your labor contractual agreement.</p>
                </div>
                <div class="form-body">
                    <form method="post" action="{{SYSTEM_SITE_URL}}admin/addDetails" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="access_token" value="{{$token}}" />
                        <div class="form-grp">
                            <label>Nome Completo / Full Name:</label>
                            <input type="text" name="full_name" placeholder="Type here" value="{{ old('full_name') }}" required/>
                        </div>
                        <div class="form-grp">
                            <label>Data de Nascimento / Date of Birth:</label>
                            <input type="input" class="form-control" id="inputDate" name="dob" placeholder="Choose date" value="{{ old('dob') }}" required>
                            <i class="far fa-calendar"></i> </div>
                        <div class="form-grp">
                            <label>Cartão de Cidadão / ID / Passport Number:</label>
                            <input type="text" class="form-control" name="passport_number" placeholder="Type here" value="{{ old('passport_number') }}" required>
                        </div>
                        <div class="form-grp">
                            <label>Cartão de Cidadão / ID / Passport Expiration date:</label>
                            <input type="text" class="form-control" id="inputDate1" name="passport_expired_date" placeholder="Choose date" value="{{ old('passport_expired_date') }}" required>
                            <i class="far fa-calendar"></i> </div>
                        <div class="form-grp">
                            <label>NIF (Número de Contribuinte) / Tax payer number:</label>
                            <input type="text" class="form-control" name="nif" placeholder="Type here" value="{{ old('nif') }}">
                        </div>
                        <div class="form-grp">
                            <label>NISS ( Segurança Social) / Social Security Number:</label>
                            <input type="text" class="form-control" name="niss" placeholder="Type here" value="{{ old('niss') }}">
                        </div>
                        <div class="form-grp">
                            <label>NISS ( Segurança Social) / Social Security Number:</label>
                            <div class="inn-grp">
                                <div class="in-form-grp">
                                    <input type="radio" name="niss_type" value="0" required/>
                                    <label>Solteiro / Single</label>
                                </div>
                                <div class="in-form-grp">
                                    <input type="radio" name="niss_type" value="1"/>
                                    <label>Casado / Married</label>
                                </div>
                                <div class="in-form-grp">
                                    <input type="radio" name="niss_type" value="2"/>
                                    <label>Divorciado / Divorced</label>
                                </div>
                                <div class="in-form-grp">
                                    <input type="radio" name="niss_type" value="3"/>
                                    <label>Viúvo / Widowed</label>
                                </div>
                                <div class="in-form-grp">
                                    <input type="radio" name="niss_type" value="4"/>
                                    <label>Separado / Separated</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-grp">
                            <label>Número de Dependentes / Number of dependents:</label>
                            <div class="inn-grp">
                                <div class="in-form-grp">
                                    <input type="radio" name="total_dependents" value="0" required/>
                                    <label>0</label>
                                </div>
                                <div class="in-form-grp">
                                    <input type="radio" name="total_dependents" value="1"/>
                                    <label>1</label>
                                </div>
                                <div class="in-form-grp">
                                    <input type="radio" name="total_dependents" value="2"/>
                                    <label>2</label>
                                </div>
                                <div class="in-form-grp">
                                    <input type="radio" name="total_dependents" value="3"/>
                                    <label>3</label>
                                </div>
                                <div class="in-form-grp others">
                                    <input type="radio" name="total_dependents" value="4"/>
                                    <label></label>
                                    <input type="text" name="others" placeholder="others"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-grp">
                            <label>NIB / IBAN:</label>
                            <input type="text" class="form-control" name="iban" placeholder="Type here" value="{{ old('iban') }}" required>
                        </div>
                        <div class="form-grp">
                            <label>Morada / Address:</label>
                            <input type="text" class="form-control" name="address" placeholder="Type here" value="{{ old('address') }}" required>
                        </div>
                        <div class="form-grp">
                            <label>Contacto Telefônico / Contact Number:</label>
                            <input type="text" class="form-control" name="contact_no" placeholder="Type here" value="{{ old('contact_no') }}" required>
                        </div>
                        <div class="form-grp">
                            <label>Endereço de E-Mail / E-mail address:</label>
                            <input type="email" class="form-control" name="email" placeholder="Type here" value="{{ old('email') }}" required>
                        </div>
                        <div class="form-grp">
                            <label>Nome para contacto de emergência / Emergency Contact Name:</label>
                            <input type="text" class="form-control" name="emergency_contact_name" placeholder="Type here" value="{{ old('emergency_contact_name') }}" required>
                        </div>
                        <div class="form-grp">
                            <label>Telefone de Contacto de Emergência / Emergency Contact Details:</label>
                            <input type="text" class="form-control" name="emergency_contact_details" placeholder="Type here" value="{{ old('emergency_contact_details') }}" required>
                        </div>
                        <div class="form-grp">
                            <label>Last employer</label>
                            <input type="text" name="last_employer" placeholder="Type here" value="{{ old('last_employer') }}"/>
                        </div>
                        <div class="form-grp">
                            <label>Designation held</label>
                            <input type="text" name="designation" placeholder="Type here" value="{{ old('designation') }}"/>
                        </div>
                        <div class="form-grp">
                            <label>years/months worked in that company</label>
                            <input type="input" class="form-control" name="total_work_time" placeholder="Total work time" value="{{ old('total_work_time') }}">
                        </div>
                        <div class="form-grp">
                            <label>Reason for leaving</label>
                            <input type="text" name="reason_of_leaving" placeholder="Type here" value="{{ old('reason_of_leaving') }}">
                        </div>
                        <div class="form-grp">
                            <label>IBAN proof (PDF)</label>
                            <input type="file" name="iban_proof" required/>
                        </div>
                        <div class="form-grp">
                            <label>ID card / if not valid, proof of renewal by the embassy (PDF)</label>
                            <input type="file" name="card_proof" required/>
                        </div>
                        <div class="form-grp">
                            <label>Residence proof</label>
                            <input type="file" name="residence_proof" required/>
                        </div>
                        <div class="form-grp">
                            <label>Educational documents</label>
                            <input type="file" name="educational_proof" required/>
                        </div>
                        <div class="form-grp">
                            <label>local references</label>
                            <input type="file" name="local_proof" required/>
                        </div>
                        <div class="form-grp">
                            <button type="submit" class="submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script> 
        <script type="text/javascript" src="{{SYSTEM_SITE_URL}}assets/hr/js/bootstrap.min.js"></script> 
        <script type="text/javascript" src="{{SYSTEM_SITE_URL}}assets/hr/js/bootstrap-datepicker.js"></script> 
        <script>
            $('#inputDate').datepicker({
            });
            $('#inputDate1').datepicker({
            });
        </script>
    </body>
</html>