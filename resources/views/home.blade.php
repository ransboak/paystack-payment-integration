<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Payment Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header text-center">
                    <h4>Payment Details</h4>
                    @if(session()->has('error')) {{session()->get('error')}} @endif
                </div>
                <div class="card-body">
                    <form action="{{route('pay')}}" method="POST">
                        @csrf
                        <input type="text" name="email" placeholder="Email Address" required> <br><br>
                        <input type="number" name="amount" placeholder="Enter amount" required> <br><br>
                        <button type="submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS (including Popper.js) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://js.paystack.co/v2/inline.js"></script>

</body>
</html>
