<!DOCTYPE html> 
<html> 
<head> 
    <title>Cetak  Barcode</title> 
</head> 
<body> 
    <table width="100%"> 
    <tr>  
      @foreach($produk  as $data) 
        <td align="center"  style="border: lpx solid #ccc"> 
         {{$data->name}}<br><br>
        <img src="data:image/png;base64,{{DNS1D::getBarcodePNG($data->barcode, 'C39')}}" height="70" width="190">
        <div style="letter-spacing:3px;font-size: 12px">{{$data->barcode }}</div>
        </td>
        @if ($no++ %3 ==0)
             </tr><tr>
        @endif
     @endforeach
    </tr>
   </tsble>
  </body>
</html>