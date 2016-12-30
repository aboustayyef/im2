<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Sign In Please</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        
    </head>
    <body>
        
    <style>
        *{margin:0; padding:0;font-family:sans-serif;}
        body,html{min-height: 100%;height:100%;}
        body{
            display: flex;
            justify-content: center;
            align-items: center;
            background:#ededed;
        }
        h1{
            margin: 45px 0;
        }
        #middle{
            padding:50px;
            background: white;
            border:5px solid #333;
            border-radius:15px;
        }
        #interface{
            padding-top: 10px;
        }
        #password {
            padding:2px;
            margin:0 10px;
        }
    </style>    
    <div id="middle">


        @if($request->session()->has('message'))
            {{$request->session()->get('message')}}
        @endif

        <h1>Please Enter Password to access this page</h1>
        <form method="POST" action="/checkPassword">
            <div id="interface">            
                {{csrf_field()}}
                <label for="password">Enter Password:</label>
                <input type="password" name="password" id="password">
                <input type="submit" name="submit">
            </div>
        </form>
    </div>



    </body>
</html>
