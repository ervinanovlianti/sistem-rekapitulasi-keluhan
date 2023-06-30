@extends('layouts.main')
@section('content')
<h5 class="text-center">Input Data Keluhan</h5>
     <div class="col-md-6">
        <div class="card shadow mb-4">
        {{-- <div class="card-header">
            <strong class="card-title">Input Keluhan Pengguna Jasa</strong>
        </div> --}}
        <div class="card-body">
            <form class="needs-validation" novalidate>
            <div class="form-row">
                <div class="col-md-6 mb-3">
                <label for="validationCustom3">First name</label>
                <input type="text" class="form-control" id="validationCustom3" value="Mark" required>
                <div class="valid-feedback"> Looks good! </div>
                </div>
                <div class="col-md-6 mb-3">
                <label for="validationCustom4">Last name</label>
                <input type="text" class="form-control" id="validationCustom4" value="Otto" required>
                <div class="valid-feedback"> Looks good! </div>
                </div>
            </div> <!-- /.form-row -->
            <div class="form-row">
                <div class="col-md-8 mb-3">
                    <div class="form-row mb-3">
                        <div class="col-md-6 mb-3">
                        <label for="date-input1">Tanggal Keluhan</label>
                        <div class="input-group">
                            <input type="text" class="form-control drgpicker" id="date-input1" value="04/24/2020" aria-describedby="button-addon2">
                            <div class="input-group-append">
                            <div class="input-group-text" id="button-addon-date"><span class="fe fe-calendar fe-16 mx-2"></span></div>
                            </div>
                        </div>
                        </div>
                        <div class="col-md-3 mb-3">
                        <label for="example-time">Time</label>
                        <input class="form-control" id="example-time" type="time" name="time" required>
                        </div>
                        <div class="col-md-3 mx-auto mb-3">
                        <p class="mb-3">Pick Up</p>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="customSwitch1" required>
                            <label class="custom-control-label" for="customSwitch1">Yes</label>
                        </div>
                        </div>
                    </div>
                <div class="col-md-4 mb-3">
                <label for="custom-phone">No. Telepon</label>
                <input class="form-control " id="custom-phone" maxlength="14" required>
                <div class="invalid-feedback"> Please enter a correct phone </div>
                </div>
            </div> <!-- /.form-row -->
            <div class="form-group mb-3">
                <label for="address-wpalaceholder">Perusahaan</label>
                <input type="text" id="address-wpalaceholder" class="form-control" placeholder="PT/CV">
                <div class="valid-feedback"> Looks good! </div>
                <div class="invalid-feedback"> Badd address </div>
            </div>
            <div class="form-group mb-3">
                <label for="validationTextarea1">Note</label>
                <textarea class="form-control" id="validationTextarea1" placeholder="Take a note here" required="" rows="3"></textarea>
                <div class="invalid-feedback"> Please enter a message in the textarea. </div>
            </div>
            <button class="btn btn-primary" type="submit">Submit form</button>
            </form>
        </div> <!-- /.card-body -->
        </div> <!-- /.card -->
                </div> <!-- /.col -->
@endsection