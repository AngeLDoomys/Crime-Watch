function validar(btn)
            {
                if(btn!="CANCELAR")
                {
                    if(document.frm_usu.frm_rut.value=="")
                    {
                        alert("Debe ingresar el RUT");
                        document.frm_usu.frm_rut.focus();
                        return false;
                    }else{
                        if(!Fn.validaRut(document.frm_usu.frm_rut.value))
                        {
                            alert("Rut Invalido");
                            document.frm_usu.frm_rut.value="";
                            document.frm_usu.frm_rut.focus();
                            return false;
                        }
                    }
                    if(document.frm_usu.frm_nombres.value=="")
                    {
                        alert("Debe ingresar el Nombre");
                        document.frm_usu.frm_nombres.focus();
                        return false;
                    }
                    if(document.frm_usu.frm_apellidos.value=="")
                    {
                        alert("Debe ingresar los Apellidos");
                        document.frm_usu.frm_apellidos.focus();
                        return false;
                    }
                    if(document.frm_usu.frm_usu.value=="")
                    {
                        alert("Debe ingresar el Correo Electronico");
                        document.frm_usu.frm_usu.focus();
                        return false;
                    }else{
                        if(!validateEmail()){
                            alert("El email no cumple con el formato correcto");
                            document.frm_usu.frm_usu.focus();
                            return false;
                        }

                    }
                    if(btn=="INGRESAR")
                    {
                        if(document.frm_usu.frm_pass.value=="")
                        {
                            alert("Debe ingresar la Contraseña");
                            document.frm_usu.frm_pass.focus();
                            return false;
                        }
                        if(document.frm_usu.frm_rep_pass.value=="")
                        {
                            alert("Debe repetir la Contraseña");
                            document.frm_usu.frm_rep_pass.focus();
                            return false;
                        }

                        if(document.frm_usu.frm_pass.value!=document.frm_usu.frm_rep_pass.value)
                        {
                            alert("Las Contraseñas Deben ser iguales");
                            document.frm_usu.frm_pass.value="";
                            document.frm_usu.frm_rep_pass.value="";
                            document.frm_usu.frm_pass.focus();
                            return false;
                        }
                    }
                    if(document.frm_usu.frm_estado.value=="")
                    {
                        alert("Debe definir el Estado");
                        document.frm_usu.frm_estado.focus();
                        return false;
                    }
                    if(document.frm_usu.frm_tipo.value=="")
                    {
                        alert("Debe seleccionar el tipo de usuario");
                        document.frm_usu.frm_tipo.focus();
                        return false;
                    }
                    document.frm_usu.accion.value=btn;
                    document.frm_usu.submit();
                }
            }

            function validateEmail(){
                
                // Get our input reference.
                var emailField = document.getElementById('frm_usu');
                
                // Define our regular expression.
                var validEmail =  /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/;
            
                // Using test we can check if the text match the pattern
                if( validEmail.test(emailField.value) ){
                    return true;
                }else{;
                    return false;
                }
            }

            var Fn = {
                // Valida el rut con su cadena completa "XXXXXXXX-X"
                validaRut : function (rutCompleto) {
                    if (!/^[0-9]+[-|‐]{1}[0-9kK]{1}$/.test( rutCompleto ))
                        return false;
                    var tmp 	= rutCompleto.split('-');
                    var digv	= tmp[1]; 
                    var rut 	= tmp[0];
                    if ( digv == 'K' ) digv = 'k' ;
                    return (Fn.dv(rut) == digv );
                },
                dv : function(T){
                    var M=0,S=1;
                    for(;T;T=Math.floor(T/10))
                        S=(S+T%10*(9-M++%6))%11;
                    return S?S-1:'k';
                }
            }