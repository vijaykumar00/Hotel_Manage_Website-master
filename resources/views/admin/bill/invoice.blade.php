<!DOCTYPE html>
<html>
<head>
	<title>
Customer invoice</title>
</head>
<body>

	<h5> First and last name: {{$reservation[0]->name}}   </h5>
	<h5> 
Check-in date: {{$reservation[0]->DateIn}}  </h5> 
	<h5> 
Date of payment: {{$reservation[0]->DateOut}}  </h5>  
	<table>
		<thead>
		    <tr>
		    	<th><h2>
content</h2></th>
		        <th><h2>Price</h2></th>
		    </tr>
	    </thead>
    <tbody>
	    @foreach ($bill as $item)
	        <tr>
	        	<td>{{$item->content}}</td>
	        	<td>{{$item->price}} $</td>
	        </tr>
	    @endforeach    
	    
    </tbody>
	</table>
	
	<h2> 
Total invoice:  {{$reservation[0]->total_bill}} $  </h2>

	

</body>
</html>