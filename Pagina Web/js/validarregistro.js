function validar(btn)
            {
                if(btn!="CANCELAR")
                {
                    if(document.frm_registro.rut.value=="")
                    {
                        alert("Debe ingresar el RUT");
                        document.frm_registro.rut.value.focus();
                        return false;
                    }else{
                        if(!Fn.validaRut(document.frm_registro.rut.value))
                        {
                            alert("Rut Invalido");
                            document.frm_registro.rut.value="";
                            document.frm_registro.rut.focus();
                            return false;
                        }
                    }
                    if(document.frm_registro.nombre.value=="")
                    {
                        alert("Debe ingresar el Nombre");
                        document.frm_registro.nombre.focus();
                        return false;
                    }
                    if(document.frm_registro.apellido.value=="")
                    {
                        alert("Debe ingresar los Apellidos");
                        document.frm_registro.apellido.focus();
                        return false;
                    }
                    if(document.frm_registro.email.value=="")
                    {
                        alert("Debe ingresar el Correo Electronico");
                        document.frm_registro.email.focus();
                        return false;
                    }else{
                        if(!validateEmail()){
                            alert("El email no cumple con el formato correcto");
                            document.frm_registro.email.focus();
                            return false;
                        }

                    }
                    if(document.frm_registro.sexo.value==""){
                        alert("Debe Ingresar su Genero");
                        document.frm_registro.sexo.focus();
                        return false;
                    }
                    if(btn=="Registrarse")
                    {
                        if(document.frm_registro.clave.value=="")
                        {
                            alert("Debe ingresar la Contraseña");
                            document.frm_registro.clave.focus();
                            return false;
                        }
                        if(document.frm_registro.reclave.value=="")
                        {
                            alert("Debe repetir la Contraseña");
                            document.frm_registro.reclave.focus();
                            return false;
                        }

                        if(document.frm_registro.clave.value!=document.frm_registro.reclave.value)
                        {
                            alert("Las Contraseñas Deben ser iguales");
                            document.frm_registro.clave.value="";
                            document.frm_registro.reclave.value="";
                            document.frm_registro.clave.focus();
                            return false;
                        }
                    }
                    if(document.frm_registro.movil.value=="")
                    {
                        alert("Debe ingresar su Telefono");
                        document.frm_registro.movil.focus();
                        return false;
                    }
                    if(document.frm_registro.fecha.value=="")
                    {
                        alert("Debe ingresar su Fecha de Nacimiento");
                        document.frm_registro.fecha.focus();
                        return false;
                    }
                    if(document.frm_registro.bienes.value=="mm/dd/yyyy")
                    {
                        alert("Debe Ingresar el numero de propiedades");
                        document.frm_registro.bienes.focus();
                        return false;
                    }
                    document.frm_registro.accion.value=btn;
                    document.frm_registro.submit();
                }
            }

            function validateEmail(){
                
                // Get our input reference.
                var emailField = document.getElementById('email');
                
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