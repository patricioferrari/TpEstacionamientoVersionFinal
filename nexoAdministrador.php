<?php

$queHago = isset($_POST['queHago']) ? $_POST['queHago'] : NULL;

switch ($queHago) {
    case "mostrarGrilla":

        require_once 'Estacionamiento.php';
        
        $ArrayDeAutos = Estacionamiento::TraerTodosLosAutos();

        $grilla = '<table class="table" border="2">
                        <thead style="background:#EAF2A2; border-style:solid;border-color:#1BA045;color:rgb(14, 26, 112); ">
                                <tr>
                                    <th rowspan="2">  PATENTE </th>
                                    <th rowspan="2">  FECHA INGRESO  </th>
                                </tr> 
                        </thead>';
        $grilla .= '<tbody>';

        foreach ($ArrayDeAutos as $auto) {
            $grilla .='<thead style="background:#EAF2A2; border-style:solid;border-color:#1BA045;color:rgb(14, 26, 112); ">';
            $grilla .= '<tr>';
            $grilla .= '<td>' . $auto["patente"] .'</td>';
            $grilla .= '<td>' . $auto["fingreso"] . '</td>';

        }
        $grilla .= '</tr>';
        $grilla .= '</table>';
        $grilla .= '<tbody>';
        echo $grilla;

        break;

    case "cargarForm":

        $form = '<form>   
                    
                    <label >INGRESAR AUTO</label>
                    <input type="text" placeholder="INGRESAR PATENTE" id="txtPatente" />
                    <input type="button" class="MiBotonUTN" onclick="AgregarAuto()" value="Estacionar Auto"  />
                </form>';
        
        echo $form;
        
        break;

    case "cargarFormEliminar":

        $form = '<form>   
                     <label >ELIMINAR AUTO</label>   
                    <input type="text" placeholder="INGRESAR PATENTE" id="txtPatente" />
                    <br>
                    <input type="button" class="MiBotonUTN" onclick="EliminarAuto()" value="Eliminar Auto"  />
                </form>';
        
        echo $form;
        
        break;

    case "agregarAuto":

    require_once 'Estacionamiento.php';

        $retorno["Exito"] = TRUE;
        $retorno["Mensaje"] = "";
                
        
        if(isset( $_POST['auto'] ))
        {
            $obj = json_decode(json_encode($_POST["auto"]));    
        }

        //var_dump(Estacionamiento::TraerUnAuto($obj->patente));
        //var_dump($obj->patente);
        //die();

        if(Estacionamiento::TraerUnAuto($obj->patente))
            {
                $retorno["Exito"] = FALSE;   
                $retorno["Mensaje"] = "El vehiculo que quiere ingresar ya esta estacionado.";
            }else
                {
                    if (!Estacionamiento::InsertarAuto($obj->patente))
                            {
                                $retorno["Exito"] = FALSE;
                                $retorno["Mensaje"] = "Lamentablemente ocurrio un error y no se pudo agregar la patente.";
                            } else {
                                $retorno["Mensaje"] = "La patente fue agregada CORRECTAMENTE!!!";
                            }

            }

        
        echo json_encode($retorno);
        break;

    case "eliminarAuto":
        
        require_once 'Estacionamiento.php';


      $retorno["Exito"] = TRUE;
        $retorno["Mensaje"] = "";
        
        if(isset( $_POST['auto'] ))
        {
            $obj = json_decode(json_encode($_POST["auto"]));    
        }        
        
        $obj = Estacionamiento::TraerUnAuto($obj->patente);

        
        if (!$obj) {
            $retorno["Exito"] = FALSE;
            $retorno["Mensaje"] = "El vehiculo que quieres sacar no se encuentra estacionado.";
        } else {
            if (!Estacionamiento::EliminarAuto($obj)) {
                $retorno["Exito"] = FALSE;
                $retorno["Mensaje"] = "Lamentablemente ocurrio un error y no se pudo sacar el vehiculo.";            
            } else {
                
                $retorno["Mensaje"] = "El vehiculo a sido retirado exitosamente.El monto a pagar es:";
            }            
        }


        
        echo json_encode($retorno);
       break;

    case "mostrarGrillaFacturacion":

        require_once 'Estacionamiento.php';
        
        $ArrayDeAutos = Estacionamiento::TraerTodosLosAutosEliminados();

        $grilla = '<table class="table" border="4">
                        <thead style="background:#EAF2A2; border-style:solid;border-color:#1BA045;color:rgb(14, 26, 112); ">
                                <tr>
                                    <th rowspan="2">  PATENTE </th>
                                    <th rowspan="2">  FECHA INGRESO  </th>
                                    <th rowspan="2">  FECHA EGRESO </th>
                                    <th rowspan="2">  COSTO  </th>
                                </tr> 
                        </thead>';
        $grilla .= '<tbody>';

        foreach ($ArrayDeAutos as $auto) {
            $grilla .='<thead style="background:#EAF2A2; border-style:solid;border-color:#1BA045;color:rgb(14, 26, 112); ">';
            $grilla .= '<tr>';
            $grilla .= '<td>' . $auto["patente"] .'</td>';
            $grilla .= '<td>' . $auto["fingreso"] . '</td>';
            $grilla .= '<td>' . $auto["fsalida"] . '</td>';
            $grilla .= '<td>' . $auto["importe_total"] . '</td>';


        }
        $grilla .= '</tr>';
        $grilla .= '</table>';
        $grilla .= '<tbody>';
        echo $grilla;

        break;
        
}