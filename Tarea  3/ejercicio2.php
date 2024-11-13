<?php
/* Añadimos la librería con las definiciones */
require_once('ejercicio1.php');

/* Preparamos un array para almacenar los objetos */
$personas=array();

/* Creamos un bucle para generar las 100 personas al azar */
for($i=0;$i<100;$i++)
{
    /* Generamos un número al azar para decidir qué tipo de persona generamos
    Hay que tener en cuenta que sólo podemos generar clases no abstractas. Por lo tanto
    son 7 opciones */
    $numeroAzar=mt_rand(0,6);

    /* Decidimos qué crear con un switch */
    switch($numeroAzar)
    {
        case 0:
            $personas[]=Administrativo::generarAlAzar();
            break;
        case 1:
            $personas[]=Conserje::generarAlAzar();
            break;
        case 2:
            $personas[]=PersonalLimpieza::generarAlAzar();
            break;           
        case 3:
            $personas[]=EmpleadoDocente::generarAlAzar();
            break;
        case 4:
            $personas[]=AlumnoESO::generarAlAzar();
            break;
        case 5:
            $personas[]=AlumnoBAC::generarAlAzar();
            break;
        case 6:
            $personas[]=AlumnoFP::generarAlAzar();
            break;
    }
}

/* Pasamos a dar la información de cuántas clases de cada tipo se han generado.
También informamos de las clases abstractas */
echo "Se han generado un total de ". Persona::numeroObjetosCreado() . " personas distribuidas como:" .PHP_EOL;
echo "\t"."Un total de ". Empleado::numeroObjetosCreado() . " empleados de los siguientes tipos:" .PHP_EOL;
echo "\t\t"."Un total de ". EmpleadoNoDocente::numeroObjetosCreado() . " empleados no docentes de los siguientes tipos:" .PHP_EOL;
echo "\t\t\t". Administrativo::numeroObjetosCreado() . " administrativos." .PHP_EOL;
echo "\t\t\t". Conserje::numeroObjetosCreado() . " conserjes." .PHP_EOL;
echo "\t\t\t". PersonalLimpieza::numeroObjetosCreado() . " limpiadores." .PHP_EOL;
echo "\t\t"."Un total de ". EmpleadoDocente::numeroObjetosCreado() . " empleados docentes." .PHP_EOL;
echo "\t"."Un total de ". Alumno::numeroObjetosCreado() . " alumnos de los siguientes tipos:" .PHP_EOL;
echo "\t\t". AlumnoESO::numeroObjetosCreado() . " alumnos de la ESO." .PHP_EOL;
echo "\t\t". AlumnoBAC::numeroObjetosCreado() . " alumnos del bachillerato." .PHP_EOL;
echo "\t\t". AlumnoFP::numeroObjetosCreado() . " alumnos de ciclos formativos." .PHP_EOL;

/* Pasamos a mostrar los saludos particulares de todas las personas */
echo "\nLos saludos de las personas son:".PHP_EOL;
for($i=0;$i<count($personas);$i++)
{
    echo "   ".$personas[$i]->trabajar();
}







/* COSAS A MAYORES PARA HACER COMPROBACIONES */

/* Comprobación del método toString */
echo "\nSi hacemos un toString:".PHP_EOL;
for($i=0;$i<count($personas);$i++)
{
    echo $personas[$i]->__toString();
}

/* Comprobación de var_dump. (Realmente ya lo hemos hecho con el debugger antes) */
echo "\nSi hacemos un var_dump:".PHP_EOL;
for($i=0;$i<count($personas);$i++)
{
    var_dump($personas[$i]);
}

/* Comprobación de los getters */
for($i=0;$i<count($personas);$i++)
{
    var_dump($personas[$i]->getNombre());
    var_dump($personas[$i]->getApellido1());
    var_dump($personas[$i]->getApellido2());
    var_dump($personas[$i]->getNacimiento());
    var_dump($personas[$i]->getDOI());
    var_dump($personas[$i]->getDireccion());
    var_dump($personas[$i]->getTelefonos());
    var_dump($personas[$i]->getSexo());

    if($personas[$i] instanceof Administrativo)
        var_dump($personas[$i]->getAnhosServicio());
    if($personas[$i] instanceof Conserje)
        var_dump($personas[$i]->getAnhosServicio());
    if($personas[$i] instanceof PersonalLimpieza)
        var_dump($personas[$i]->getAnhosServicio());

    if($personas[$i] instanceof EmpleadoDocente)
    {
        var_dump($personas[$i]->getAnhosServicio());
        var_dump($personas[$i]->getMaterias());
        var_dump($personas[$i]->getCargo());
    }

    if($personas[$i] instanceof AlumnoESO)
    {
        var_dump($personas[$i]->getCurso());
        var_dump($personas[$i]->getGrupo());
    }
    if($personas[$i] instanceof AlumnoBAC)
    {
        var_dump($personas[$i]->getCurso());
        var_dump($personas[$i]->getGrupo());
    }
    if($personas[$i] instanceof AlumnoFP)
    {
        var_dump($personas[$i]->getCurso());
        var_dump($personas[$i]->getGrupo());
        var_dump($personas[$i]->getCicloFormativo());
    }
}

/* Comprobación de los setters */
for($i=0;$i<count($personas);$i++)
{
    $personas[$i]->setNombre('a');
    var_dump($personas[$i]->getNombre());
    $personas[$i]->setApellido1('b');
    var_dump($personas[$i]->getApellido1());
    $personas[$i]->setApellido2('c');
    var_dump($personas[$i]->getApellido2());
    $personas[$i]->setNacimiento('d');
    var_dump($personas[$i]->getNacimiento());
    $personas[$i]->setDOI('e');
    var_dump($personas[$i]->getDOI());
    $personas[$i]->setDireccion('f');
    var_dump($personas[$i]->getDireccion());
    $personas[$i]->setTelefonos(array('g','h'));
    var_dump($personas[$i]->getTelefonos());
    $personas[$i]->setSexo(Persona::SEXOS[0]);
    var_dump($personas[$i]->getSexo());

    if($personas[$i] instanceof Administrativo)
    {
        $personas[$i]->setAnhosServicio('i');
        var_dump($personas[$i]->getAnhosServicio());
    }
        
    if($personas[$i] instanceof Conserje)
    {
        $personas[$i]->setAnhosServicio('i');
        var_dump($personas[$i]->getAnhosServicio());
    }
    if($personas[$i] instanceof PersonalLimpieza)
    {
        $personas[$i]->setAnhosServicio('i');
        var_dump($personas[$i]->getAnhosServicio());
    }

    if($personas[$i] instanceof EmpleadoDocente)
    {
        $personas[$i]->setAnhosServicio('i');
        var_dump($personas[$i]->getAnhosServicio());
        $personas[$i]->setMaterias(array('j','k'));
        var_dump($personas[$i]->getMaterias());
        $personas[$i]->setSexo(EmpleadoDocente::CARGOS[0]);
        var_dump($personas[$i]->getCargo());
    }

    if($personas[$i] instanceof AlumnoESO)
    {
        $personas[$i]->setCurso('l');
        var_dump($personas[$i]->getCurso());
        $personas[$i]->setGrupo('m');
        var_dump($personas[$i]->getGrupo());
    }
    if($personas[$i] instanceof AlumnoBAC)
    {
        $personas[$i]->setCurso('l');
        var_dump($personas[$i]->getCurso());
        $personas[$i]->setGrupo('m');
        var_dump($personas[$i]->getGrupo());
    }
    if($personas[$i] instanceof AlumnoFP)
    {
        $personas[$i]->setCurso('l');
        var_dump($personas[$i]->getCurso());
        $personas[$i]->setGrupo('m');
        var_dump($personas[$i]->getGrupo());
        $personas[$i]->setCicloFormativo('m');
        var_dump($personas[$i]->getCicloFormativo());
    }
}