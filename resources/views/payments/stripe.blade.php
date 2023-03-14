<!DOCTYPE html>
<html>
<head>
    <title> Tournament Player Stripe Payment</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<style type="text/css">
   body {
  display: flex;
  justify-content: center;
  align-items: center;
  background: #242d60;
  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto',
  'Helvetica Neue', 'Ubuntu', sans-serif;
  height: 100vh;
  margin: 0;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}
section {
  background: #ffffff;
  display: flex;
  margin: 0 auto;
  flex-direction: column;
  width: 400px;
  height: 112px;
  border-radius: 6px;
  justify-content: space-between;
}
.product {
  display: flex;
}
.description {
  display: flex;
  flex-direction: column;
  justify-content: center;
}
p {
  font-style: normal;
  font-weight: 500;
  font-size: 14px;
  line-height: 20px;
  letter-spacing: -0.154px;
  color: #242d60;
  height: 100%;
  width: 100%;
  padding: 0 20px;
  display: flex;
  align-items: center;
  justify-content: center;
  box-sizing: border-box;
}
img {
  border-radius: 6px;
  margin: 10px;
  width: 54px;
  height: 57px;
}
h3,
h5 {
  font-style: normal;
  font-weight: 500;
  font-size: 14px;
  line-height: 20px;
  letter-spacing: -0.154px;
  color: #242d60;
  margin: 0;
}
h5 {
  opacity: 0.5;
}
button {
  height: 36px;
  background: #556cd6;
  color: white;
  width: 100%;
  font-size: 14px;
  border: 0;
  font-weight: 500;
  cursor: pointer;
  letter-spacing: 0.6;
  border-radius: 0 0 6px 6px;
  transition: all 0.2s ease;
  box-shadow: 0px 4px 5.5px 0px rgba(0, 0, 0, 0.07);
}
button:hover {
  opacity: 0.8;
}  
</style>
<body>
<div class="container">
    
    <!-- <h2 class="text-center">Tournament Player Subscription Plan</h2> -->
    
    <section>
      <div class="product">
        <img src="https://i.imgur.com/EHyR2nP.png" alt="The cover of Stubborn Attachments" />
        <div class="description">
          <h3>Tournament Player Subscription</h3>
          <h5>$1</h5>
        </div>
      </div>
      <form action="{{route('payment.post')}}" method="POST">
        @csrf
        <input type='hidden' name='stripe_token' value="{{$token}}"/>
        <button type="submit" id="checkout-button">Checkout</button>
      </form>
    </section>
        
</div>
    
</body>
    
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    
</html>