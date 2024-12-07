<?php

include("setup/config.php");

session_start();

if($_POST['txt']=='')
{
    $sql="select * from usuarios";
}else{
    $sql="select * from usuarios WHERE nombres LIKE '%".$_POST['txt']."%' or apellidos LIKE '%".$_POST['txt']."%' or usuario LIKE '%".$_POST['txt']."%'";
}


?>
            <div class="card">
                <div class="card-header textalign color"><strong>Listados de Usuarios</strong></div>
                <div class="card-body">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Nº</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Usuario</th>
                        <th>Estado</th>
                        <th>Tipo de Usuario</th>
                        <th>Acción</th>
                    </tr>
                    </thead>
                    <?php
                        
                        $result=mysqli_query(conectar(),$sql);
                        $con=mysqli_num_rows($result);
                    ?>
                    <tbody>
                    <?php
                    $cont=1;
                    while($datos=mysqli_fetch_array($result))
                    {
                        ?>
                    <tr>
                        <td><?php echo $cont;?></td>
                        <td><?php echo $datos['nombres'];?></td>
                        <td><?php echo $datos['apellidos'];?></td>
                        <td><?php echo $datos['usuario'];?></td>
                        <td><?php

                        if($datos['estado']==1)
                        {
                            ?>
                            <img src="img/icons/ok2.png" width="24px">
<?php
                        }else{
                            ?>
                            <a href="crud_usuarios.php?idusu=<?php echo $datos['idusu'];?>&est=idusu=<?php echo $datos['estado'];?>"><img src="img/icons/x2.png" width="24px"></a>
<?php
                        }
                        
                        ?></td>
                        <td>
                            <p class="<?php echo color ($datos['idtipousu']);?>"><strong><?php echo sabertipo($datos['idtipousu']);?></strong></p>
                        </div> 
                        </td>
                        <td>
                            <?php
                            if($_SESSION['tipo']!=$datos['idtipousu'])
                            {
                                ?>
                            <a href="dashboard_usuarios.php?idusu=<?php echo $datos['idusu'];?>"><img src="img/icons/update.png" width="24px"></a>&nbsp;&nbsp;&nbsp;<?php if($datos['estado']==1){?>|&nbsp;&nbsp;&nbsp;<a href="crud_usuarios.php?idusu=<?php echo $datos['idusu'];?>&est=<?php echo $datos['estado'];?>"><img src="img/icons/borrar.png" width="24px"></a><?php } ?>
                            <?php
                            }
                            ?>
                        </td>
                    </tr>
                    <?php
                       $cont++;
                    }
                    ?>
                    </tbody>
                </table>
                </div>
                <div class="card-footer color2">Total de Usuarios (<strong><?php echo $con;?></strong>) | <a class="quitarlink alinearderecha" href="exportarexcel.php"><img src="img/excel.png" width=24px>Exportar a Excel</a></div> 
            </div>