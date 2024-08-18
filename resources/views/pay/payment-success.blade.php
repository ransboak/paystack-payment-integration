<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Bootstrap Example</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
      <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" >
      <style type="text/css">

      </style>
   </head>
   <body>

      <div class="container-fluid" style="display: flex; flex-direction: column; text-align: center; justify-content: center; width: 100%; height: 100vh; background-color: white;">
         <div class="row justify-content-center" style=" padding: 20px;">
            <div class="col-xl-5 col-lg-6 col-md-7 col-sm-9 shadow" style="background-color: whitesmoke; margin: 0px auto; padding:40px 20px; min-height: 200px; border-radius: 10px;">
                <div>
                    <img  src="{{asset('shelterlyf.png')}}" style="width: 12rem; margin-bottom:-2rem" class="center" alt="Stronger With Capricorn" />
                </div>
               <i class="fa fa-check-circle-o fa-5x" style="color:limegreen;"></i><br>
               <span style="font-size: 23px; font-weight: bold; color: limegreen; letter-spacing: 1px; display: inline-block; margin-bottom: 15px;">
                  Sucess!
               </span><br>
               <span style="font-size: 15px; font-weight: 600; color: dodgerblue; letter-spacing: .3px; display: inline-block; margin-bottom: 15px;">
                  Your payment has been confirmed and your viewing has been successfully booked!
               </span>
            </div>
         </div>
      </div>


   </body>
</html>
