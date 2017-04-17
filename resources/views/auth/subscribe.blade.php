@extends('layouts.front')

@section('content')
    <div class="container" >
        <div class="row">
            <div class="col-md-6 col-md-offset-3" id="form-registration">
                <div class="panel panel-default" >
                    <div class="panel-body">
                        <h4>Inschrijving</h4>
                        <form class="form" role="form" method="POST" action="{{ route('subscribe') }}">
                            {{ csrf_field() }}

                            <div class="col-md-12 form-group">
                                <label for="subscription" class="control-label">Formule</label>
                                <select id="subscription" name="subscription" class="form-control">
                                    <option value="1">Starter</option>
                                    <option value="2">Basis</option>
                                    <option value="3">Professioneel</option>
                                </select>

                            </div>

                            <div class="col-md-12 form-group">
                               <h5>Samenvatting van gekozen optie</h5>
                            </div>

                            <div class="col-md-12 form-group">
                                <label for="paymentOptions" class="control-label">Betalingsmethode</label>
                                    <div class="col-md-12">
                                        <div class="radio">
                                            <label for="paymentOptions-0">
                                                <input type="radio" name="checkboxes" id="paymentOptions-0" value="1">
                                                Facturatie
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label for="paymentOptions-1">
                                                <input type="radio" name="checkboxes" id="paymentOptions-1" value="2">
                                                Online betaling
                                            </label>
                                        </div>
                                    </div>
                            </div>

                            {{--Facturatie--}}
                            <div class="col-md-12 form-group">
                                <label for="invoice" class="control-label">Facturatie periode</label>
                                <select id="invoice" name="invoice" class="form-control">
                                    <option value="1">Maandelijks</option>
                                    <option value="3">Kwartaal</option>
                                    <option value="12">Jaarbasis</option>
                                </select>
                            </div>

                            <div class="col-md-12 form-group">
                                <label for="business" class=control-label">Bedrijfsnaam</label>
                                <input id="business" type="text" class="form-control" name="business" >
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="vat" class=control-label">BTW-nummer</label>
                                <input id="vat" type="text" class="form-control" name="vat" >
                            </div>
                            <div class="col-md-12 form-group">
                                <label><input type="checkbox" name="address-business"> De adresgegevens van de geregistreerde gebruiker komen overeen met de locatie van het bedrijf</label>
                            </div>
                            <div class="col-md-6 form-group{{ $errors->has('street') ? ' has-error' : '' }}">
                                <label for="street" class="col-md-3control-label">Straat</label>
                                <input id="street" type="text" class="form-control" name="street"  required>

                                @if ($errors->has('street'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('street') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-3 form-group{{ $errors->has('street_number') ? ' has-error' : '' }}">
                                <label for="street_number" class="col-md-3control-label">Nummer</label>
                                <input id="street_number" type="text" class="form-control" name="street_number"  required>

                                @if ($errors->has('street_number'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('street_number') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-3 form-group{{ $errors->has('street_bus_number') ? ' has-error' : '' }}">
                                <label for="street_bus_number" class="col-md-3control-label">Bus</label>
                                <input id="street_bus_number" type="text" class="form-control" name="street_bus_number">

                                @if ($errors->has('street_bus_number'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('street_bus_number') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-6 form-group{{ $errors->has('zipcode') ? ' has-error' : '' }}">
                                <label for="zipcode" class="col-md-3control-label">Postcode</label>
                                <input id="zipcode" type="text" class="form-control" name="zipcode"  required>

                                @if ($errors->has('zipcode'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('zipcode') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-6 form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                                <label for="city" class="col-md-3control-label">Stad</label>
                                <input id="city" type="text" class="form-control" name="city"  required>

                                @if ($errors->has('city'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('city') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-12 form-group">
                                <label><input type="checkbox" required> Ik accepteer de <a>betalingscondities</a></label>
                            </div>

                            {{--Online betaling--}}

                            <div class="col-md-12 form-group">

                            </div>









                            <div class="col-md-12 form-group">
                                <a href="{{url('/')}}" class="btn btn-default">Annuleer</a>

                                <button  class="pull-right btn btn-success">
                                    Registreer
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection