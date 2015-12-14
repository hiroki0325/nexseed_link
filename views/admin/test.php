<?php 

 ?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
   <!-- JS -->
   <script src="jquery-1.2.6.min.js" type="text/javascript" charset="utf-8"></script>
   <script src="jquery.tablesorter.min.js" type="text/javascript" charset="utf-8"></script>
   <script type="text/javascript">
     $(document).ready(function(){ 
       $("#myTable").tablesorter();
     }); 
   </script>

 </head>
 <body>
   
 </body>
 </html>
 <table id="myTable" class="tablesorter">


    <!-- ▼必ずthead要素が必要です。 -->
    <thead>
       <tr>
          <th>都道府県名</th>
          <th>総人口(万人)</th>
          <th>面積(km²)</th>
          <th>人口密度(人/km²)</th>
       </tr>
    </thead>

    <!-- ▼表の中身はtbody要素に。 -->
    <tbody>
       <tr>
          <td>東京都</td>
          <td>1327</td>
          <td>2189</td>
          <td>6000</td>
       </tr>
       <tr>
          <td>大阪府</td>
          <td>886</td>
          <td>1899</td>
          <td>4700</td>
       </tr>

       ：　：　：

       <tr>
          <td>兵庫県</td>
          <td>556</td>
          <td>8396</td>
          <td>662</td>
       </tr>
    </tbody>
 </table>

