var token=$('meta[name="csrf-token"]').attr('content');
var total_weight=0;
var total=0;
function slctProd(cont,id,price,weight){
    if($('#cbprod_'+cont).is(':checked'))
        $('#qty_'+cont).prop('required',true).prop('readonly',false);
    else{
        qty=$('#qty_'+cont).val();
        $('#qty_'+cont).prop('required',false).prop('readonly',true).val('');
        $('#total_'+cont).val('');
        $('#total_w_'+cont).val('');
        total=total-(price*qty);
        total_weight=total_weight-(weight*qty);
    }
}
function qtyProd(cont,price,weight,qty){
    if(qty>0){
        $('#total_'+cont).val((price*qty).toFixed(2));
        $('#total_w_'+cont).val((weight*qty).toFixed(2));
    }
    else if(qty==0 || qty==''){
        $('#total_'+cont).val('');
        $('#total_w_'+cont).val('');
    }
    var len=$('#cont_i').val();
    total=0;
    total_weight=0;
    for(i=0;i<len;i++){
        if($('#total_'+i).val()!='' && $('#total_w_'+i).val()!=''){
            total=total+parseFloat($('#total_'+i).val());
            total_weight=total_weight+parseFloat($('#total_w_'+i).val());
        }
    }
    $('#total').val(total.toFixed(2));
    $('#total_w').val(total_weight.toFixed(2));
    calculateSize();
}
function calculateSize(){
    if(total_weight>0 && total_weight<=5)
        $('#size').val('S');
    else if(total_weight>5 && total_weight<=15)
        $('#size').val('M');
    else if(total_weight>15 && total_weight<=25)
        $('#size').val('L');
    else
        $('#size').val('');
}
$(document).ready(()=>{
    $('#zip_code').blur(()=>{
        var zip_c=$('#zip_code').val();
        if(zip_c.length==5){
            $.ajax({
				url: '/get-city-state/'+zip_c,
				type: 'POST',
				data:{_token:token},
				success: function(data){
                    if(data!='error'){
                        var arr=JSON.parse(data);
                        $('#city').val(arr.city);
                        $('#state').val(arr.state);
                    }
					else
						bootbox.alert('Verifique el código postal');
				},
				error: function (e,data) {
					bootbox.alert('Ocurrió un error');
				}
			});
        }
    });
    $.validator.addMethod("validateCoor", 
        function(value, element){
            var result = true;
            if(!value.match(/^[-]?\d+[\.]?\d*, [-]?\d+[\.]?\d*$/)){
                return false;
            }
            const [latitude, longitude]=value.split(",");
            return (latitude>-90 && latitude<90 && longitude>-180 && longitude<180); 
        }, "Las coordenadas no son válidas"
    );
    $('#form_order').validate({
		ignore: '',
		rules: {
			total_w: {
				required: true,
				min: 0.1,
                max: 25.00
			},
			total: {
				required: true,
				min: 0.1,
            },
            zip_code:{
                minlength: 5,
                maxlength: 5,
            },
            coordinate:{
                validateCoor:false
            }
		},
		messages: {
			total_w:{
				required: "Debe seleccionar al menos un producto",
				min: "Debe seleccionar al menos un producto",
                max: "El peso no puede ser mayor a 25Kg. No cuenta con el servicio estándar para ello, comuníquese con la empresa para realizar un convenio especial"
			},
			total:{
				required: "Debe seleccionar al menos un producto",
				min: "Debe seleccionar al menos un producto",
            },
            coordinate:{
                validateCoor: 'Las coordenadas no son válidas'
            }
		},
		submitHandler: function(form){
            $.ajax({
				url: '/save-order',
				type: 'POST',
				data: $("#form_order").serialize(),
				success: function(data){
                    if(data>0){
                        bootbox.alert('Se generó la orden de manera correcta.');
                        setTimeout(()=>{
							window.location.href='ordenes';
						},3000);
                    }
                    else{
                        bootbox.alert('Ocurrió un error');
                        console.log(data);
                    }
				},
				error: function (e,data) {
					bootbox.alert(e);
				}
			});
		}
 	});
});