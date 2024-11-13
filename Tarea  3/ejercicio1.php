<?php

/* Definimos la clase Persona 
Es abstracta */
abstract class Persona
{
    /* Definimos un array para guardar los géneros */
    public const SEXOS=array('masculino','femenino');

    /* Creamos una variable para guardar el número de objetos de esta clase que se han creado
    Estrictamente, como es abstracta, no se crea ninguna. Pero como la tarea la pide, vamos a 
    entender que cuenta todos los objetos de las clases que heredan de esta. Esto quedará más claro
    al definir los constructores. Realmente lo que se cuenta es el número de personas */
    private static $numPersonas=0;

    /* Definimos las propiedades. De tipo protected para que las puedan usar las clases heredades */
    protected $nombre;
    protected $apellido1;
    protected $apellido2;
    protected $nacimiento;
    protected $doi; // DOI: Documento oficial de identidad
    protected $direccion;
    protected $telefonos;
    protected $sexo;

    /* Definimos setters y getters*/
    public function setNombre($nomb)
    {
        $this->nombre=$nomb;
    }
    public function getNombre()
    {
        return $this->nombre;
    }

    public function setApellido1($ape1)
    {
        $this->apellido1=$ape1;
    }
    public function getApellido1()
    {
        return $this->apellido1;
    }

    public function setApellido2($ape2)
    {
        $this->apellido2=$ape2;
    }
    public function getApellido2()
    {
        return $this->apellido2;
    }

    public function setNacimiento($nace)
    {
        $this->nacimiento=$nace;
    }
    public function getNacimiento()
    {
        return $this->nacimiento;
    }

    public function setDOI($do)
    {
        $this->doi=$do;
    }
    public function getDOI()
    {
        return $this->doi;
    }

    public function setDireccion($dire)
    {
        $this->direccion=$dire;
    }
    public function getDireccion()
    {
        return $this->direccion;
    }

    public function setTelefonos($tele)
    {
        $this->telefonos=$tele;
    }
    public function getTelefonos()
    {
        return $this->telefonos;
    }

    public function setSexo($sex)
    {
        $this->sexo=$sex;
    }
    public function getSexo()
    {
        return $this->sexo;
    }


    /* Definimos el contructor */
    public function __construct() // Implementamos dos versiones
                                  // 1ª: Sin argumentos
                                  // 2ª: Con un argumento que consiste en una lista con las propiedades ordenadas
    {
        $num = func_num_args(); //guardamos el número de argumentos
        switch ($num) 
        {
            case 0:
                break;
            case 1:
                $this->nombre = func_get_arg(0)[0];
                $this->apellido1 = func_get_arg(0)[1];
                $this->apellido2 =func_get_arg(0)[2];
                $this->nacimiento = func_get_arg(0)[3];
                $this->doi = func_get_arg(0)[4];
                $this->direccion = func_get_arg(0)[5];
                $this->telefonos = func_get_arg(0)[6];
                $this->sexo = func_get_arg(0)[7];
        }

        /* Incrementamos en una unidad el número de personas creadas 
        Esto es curioso: $this->propiedad y self::$propiedad */
        self::$numPersonas++;
    }

    /* Definimos el destructor, llevando la cuenta del número de personas */
    public function __destruct() 
    {
        self::$numPersonas--;
    }

    /* Como es una clase abstracta tenemos que entender que esta función devuelve el número 
    de objetos creados pertenecientes a subclases que heredan de esta. Objetos puros de esta
    clase no puede haber ninguno. De todas formas, es útil para llevar las cuentas */
    public static function numeroObjetosCreado()
    {
        return self::$numPersonas;
    }

    /* Implementamos la función toString que pide la tarea */
    public function __toString()
    {
        $resultado="CLASE PADRE: ". self::class . PHP_EOL;
        $resultado.="Nombre y apellidos: " . $this->nombre . " " . $this->apellido1 . " " . $this->apellido2 .PHP_EOL;
        $resultado.="DOI: " . $this->doi .PHP_EOL;
        $resultado.="Dirección: " . $this->direccion .PHP_EOL;
        $resultado.="Teléfonos: ";
        foreach($this->telefonos as $telefono)
            $resultado.=$telefono ." ";
        $resultado.=PHP_EOL;
        $resultado.="Sexo: " . $this->sexo .PHP_EOL;
      
        return $resultado;
    }

    /* Como esta clase es abstracta y la tarea nos dice que tienen que estar en todas las clases, no
    queda más remedio que hacer abstractas también las siguientes funciones. Si se definiesen, nunca se podría llamar
    a través de un objeto de esta clase porque éstos no pueden existir*/
    abstract public function trabajar();
    /* Pero la siguiente parece además más propia de asignarla a la clase que al objeto, por eso la hacemos static */
    abstract public static function generarAlAzar();

    /* Funciones que vamos a utilizar en la generación automática de objetos. Las hacemos propias de la clase y no del objeto con static */
    protected static function generarCadenaAleatoria($longitudMinima,$longitudMaxima)
    {
        /* Es un refrito de varias opciones que encontré en Google */
        $longitud=mt_rand($longitudMinima, $longitudMaxima);
        $caracteresPermitidos = 'abcdefghijklmnopqrstuvwxyz';
        $numeroCaracteresPermitidos=strlen($caracteresPermitidos);
        $random_string = '';
        for($i = 0; $i < $longitud; $i++) 
        {
            $random_caracter = $caracteresPermitidos[mt_rand(0, $numeroCaracteresPermitidos - 1)];
            $random_string .= $random_caracter;
        }
        return $random_string;
    }
    protected static function generarDOIAleatorio()
    {
        /* Está inspirada en la anterior */
        $caracteresPermitidos = '1234567890';
        $numeroCaracteresPermitidos=strlen($caracteresPermitidos);
        $random_string = '';
        for($i = 0; $i < 8 ; $i++) 
        {
            $random_caracter = $caracteresPermitidos[mt_rand(0, $numeroCaracteresPermitidos - 1)];
            $random_string .= $random_caracter;
        }
        return $random_string;
    }
    protected static function generarSexoAleatorio() // Sin comentarios
    {
        $sex=Persona::SEXOS[mt_rand(0,1)];
        return $sex;
    }
    protected static function generarTelefonosAleatorios($numeroMaximo)
    {
        /* Crea un array de teléfonos. Serán entre 1 y numeroMaximo */
        $longitud=mt_rand(1, $numeroMaximo); 
        $caracteresPermitidos = '1234567890';
        $numeroCaracteresPermitidos=strlen($caracteresPermitidos);
        $telefons=array();    
        for($i = 0; $i < $longitud; $i++) 
        {
            $random_string = '';
            for($j=0;$j < 9; $j++) // Entendemos que los teléfonos tienen 9 cifras
            {
                $random_caracter = $caracteresPermitidos[mt_rand(0, $numeroCaracteresPermitidos - 1)];
                $random_string .= $random_caracter;
            }
            /* Guardamos el teléfono generado */
            $telefons[]=$random_string;
        }
        return $telefons;
    }
    protected static function generarNacimientoAleatorio($start_date, $end_date)
    {
        /* Vamos a generar una fecha aleatoria entre las dos dadas */
        $min = strtotime($start_date);
        $max = strtotime($end_date);

        $randomTimestamp = mt_rand($min, $max);

        return date('d/m/Y', $randomTimestamp);
    }
}

    /* Generamos la clase Empleado. También es abstracta */
    abstract class Empleado extends Persona
    {
        /* Definimos sus propiedades */
        protected $anhosServicio;

        /* Como en el caso anterior, definimos una variable para guardar el número de Empleados generados.
        Como antes, cuenta los objetos de clases que heredan de esta */
        private static $numEmpleados=0;

        /* Definimos setters y getters */
        public function setAnhosServicio($anhos)
        {
            $this->anhosServicio=$anhos;
        }
        public function getAnhosServicio()
        {
            return $this->anhosServicio;
        }

        /* Definimos el constructor. Aquí ya se ve que va a llamar al constructor de la clase padre (Persona), por 
        lo que al final también se contará el número de personas creadas. Es modelo se repetirá en lo sucesivo */
        public function __construct() // Implementamos dos versiones
                                      // 1ª: Sin argumentos
                                      // 2ª: Con un argumento que consiste en una lista con las propiedades ordenadas (padre y luego hijo)
        {
            $num = func_num_args(); //guardamos el número de argumentos
            switch ($num) 
            {
                case 0:
                    parent::__construct();
                    break;
                case 1:
                    parent::__construct(func_get_arg(0));
                    $this->anhosServicio = func_get_arg(0)[8];
            }

            self::$numEmpleados++;
        }

        /* Destructor */
        public function __destruct() 
        {
            self::$numEmpleados--;
        }

        /* Como es una clase abstracta tenemos que entender que esta función devuelve el número 
        de objetos creados pertenecientes a subclases que heredan de esta. Objetos puros de esta
        clase no puede haber ninguno. De todas formas, es útil para llevar las cuentas */
        public static function numeroObjetosCreado()
        {
            return self::$numEmpleados;
        }

        /* Definimos la clase toString. Se llama al de la clase padre y luego se añade lo característico
        de esta clase */
        public function __toString()
        {
            $resultado= parent::__toString();
            $resultado.="\tCLASE HIJO: ".self::class  .PHP_EOL;
            $resultado.="\t"."Años de servicio: " . $this->anhosServicio .PHP_EOL;
            
            return $resultado;
        }


        /* Como la clase es abstracta y la tarea nos dice que tienen que estar en todas las clases, no
        queda más remedio que hacer abstractas también las siguientes funciones. Si se definiesen, nunca se podría llamar
        a través de un objeto de esta clase porque éstos no pueden existir*/
        abstract public function trabajar();
        /* Pero la siguiente parece además más propia de asignarla a la clase que al objeto, por eso la hacemos static */
        abstract public static function generarAlAzar();
    }

        /* Definimos la clase EmpleadoNoDocente que hereda de Empleado. Seguimos todavía con clases abstractas */
        abstract class EmpleadoNoDocente extends Empleado
        {
            /* Como hasta ahora, definimos la variable para guardar el número de empleados no docentes que se generan */
            private static $numEmpleadosNoDocentes=0;

            /* Definimos el constructor. Seguimos de nuevo el modelo de llamar al contructor de la clase padre (que a su vez llama al suyo)*/
            public function __construct() // Implementamos dos versiones
                                          // 1ª: Sin argumentos
                                          // 2ª: Con un argumento que consiste en una lista con las propiedades ordenadas (padre y luego hijo)
            {
                $num = func_num_args(); //guardamos el número de argumentos
                switch ($num) 
                {
                    case 0:
                        parent::__construct();
                        break;
                    case 1:
                        parent::__construct(func_get_arg(0));
                }

                self::$numEmpleadosNoDocentes++;
            }

            /* Definimos el destructor */
            public function __destruct() 
            {
                self::$numEmpleadosNoDocentes--;
            }

            /* Como es una clase abstracta tenemos que entender que esta función devuelve el número 
            de objetos creados pertenecientes a subclases que heredan de esta. Objetos puros de esta
            clase no puede haber ninguno. De todas formas, es útil para llevar las cuentas */
            public static function numeroObjetosCreado()
            {
                return self::$numEmpleadosNoDocentes;
            }

            /* Definimos la función toString, que llama a la de su padre y añade lo específico */
            public function __toString()
            {
                $resultado= parent::__toString();
                $resultado.="\t\tCLASE HIJO: ".self::class  .PHP_EOL;
                
                return $resultado;
            }

            /* Como la clase es abstracta y la tarea nos dice que tienen que estar en todas las clases, no
            queda más remedio que hacer abstractas también las siguientes funciones. Si se definiesen, nunca se podría llamar
            a través de un objeto de esta clase porque éstos no pueden existir*/
            abstract public function trabajar();
            /* Pero la siguiente parece además más propia de asignarla a la clase que al objeto, por eso la hacemos static */
            abstract public static function generarAlAzar();

        }

            /* Definimos la primera clase no abstracta (Administrativo) como heredera de EmpleadoNoDocente*/
            class Administrativo extends EmpleadoNoDocente
            {
                /* Definimos la variable para guardar (ahora sí) el número de objetos creados pertenecientes a esta clase */
                private static $numAdministrativos=0;

                /* Implementamos el contructor. Como siempre, a través de llamar al de su padre y añadir lo propio de la clase*/
                public function __construct() // Implementamos dos versiones
                                              // 1ª: Sin argumentos
                                              // 2ª: Con un argumento que consiste en una lista con las propiedades ordenadas (padre y luego hijo)
                {
                    $num = func_num_args(); //guardamos el número de argumentos
                    switch ($num) 
                    {
                        case 0:
                            parent::__construct();
                        break;
                        case 1:
                            parent::__construct(func_get_arg(0));
                    }

                    self::$numAdministrativos++;
                }

                /* Definimos el destructor. Como siempre, actualizando el número de objetos */
                public function __destruct() 
                {
                    self::$numAdministrativos--;
                }

                /* Definimos la función que nos devuelve el número objetos creados pertenecientes a esta clase.
                Ahora sí son realmente objetos */
                public static function numeroObjetosCreado()
                {
                    return self::$numAdministrativos;
                }
                
                /* Definimos la función toString */
                public function __toString()
                {
                    $resultado= parent::__toString();
                    $resultado.="\t\t\tCLASE HIJO: ".self::class  .PHP_EOL;
                    
                    return $resultado;
                }

                /* Implementamos la función trabajar(). Ahora ya no es abstracta */ 
                public function trabajar()
                {
                    /* Ajustamos su contenido para que represente realmente una persona administrativa */
                    $resultado='Soy ';
                    if($this->sexo =='masculino')
                        $resultado.="un administrativo ";
                    else
                        $resultado.="una administrativa ";
                    $resultado.="con " . $this->anhosServicio . " años de servicio.".PHP_EOL;
                    return $resultado;
                }

                /* Implementamos la función generarAlAzar. Ahora tampoco es abstracta.
                Generamos los datos necesarios y los almacenamos en un array para pasárselo al contructor */
                public static function generarAlAzar()
                {
                    /* Estos son los datos necesarios para generar la parte de Persona */
                    $nombreA=Persona::generarCadenaAleatoria(3,20);
                    $apellido1A=Persona::generarCadenaAleatoria(3,20);
                    $apellido2A=Persona::generarCadenaAleatoria(3,20);
                    $nacimientoA=Persona::generarNacimientoAleatorio('1/1/1940','1/1/2006');
                    $doiA=Persona::generarDOIAleatorio();
                    $direccionA=Persona::generarCadenaAleatoria(10,30);
                    $telefonosA=Persona::generarTelefonosAleatorios(3);
                    $sexoA=Persona::generarSexoAleatorio();

                    /* Esta es la parte específica de Administrativo (realmente Empleado) */
                    $anhosServicioA=mt_rand(0,40); // Es cierto que podría no ser coherente con el año de nacimiento

                    $row=array($nombreA,$apellido1A,$apellido2A,$nacimientoA,$doiA,$direccionA,$telefonosA,$sexoA,$anhosServicioA);

                    $administrativo=new Administrativo($row);
                    return $administrativo;
                }
            }

            /* Generamos la clase Conserje. Es totalmente paralela a Administrativo */
            class Conserje extends EmpleadoNoDocente
            {
                /* Definimos la variable para guardar el número de objetos */
                private static $numConserjes=0;

                /* Definimos el contructor */
                public function __construct() // Implementamos dos versiones
                                              // 1ª: Sin argumentos
                                              // 2ª: Con un argumento que consiste en una lista con las propiedades ordenadas (padre y luego hijo)
                {
                    $num = func_num_args(); //guardamos el número de argumentos
                    switch ($num) 
                    {
                        case 0:
                            parent::__construct();
                        break;
                        case 1:
                            parent::__construct(func_get_arg(0));
                    }

                    self::$numConserjes++;
                }

                /* Definimos el destructor */
                public function __destruct() 
                {
                    self::$numConserjes--;
                }

                /* Definimos la función para devolver el número de objetos pertenecientes a esta clase */
                public static function numeroObjetosCreado()
                {
                    return self::$numConserjes;
                }

                /* Definimos la función toString */
                public function __toString()
                {
                    $resultado= parent::__toString();
                    $resultado.="\t\t\tCLASE HIJO: ".self::class  .PHP_EOL;
                    
                    return $resultado;
                }

                /* Creamos la función trabajar con contenido específico, pero hay poco cambio con respecto al del administrativo */
                public function trabajar()
                {
                    $resultado='Soy ';
                    if($this->sexo =='masculino')
                        $resultado.="un conserje ";
                    else
                        $resultado.="una conserje ";
                    $resultado.="con " . $this->anhosServicio . " años de servicio.".PHP_EOL;
                    return $resultado;
                }

                /* Implementamos la función para generar al azar un conserje.
                Como en el caso del Administrativo, tiene la parte de datos para Persona y la parte
                del Conserje (realmente Empleado) */
                public static function generarAlAzar()
                {
                    $nombreA=Persona::generarCadenaAleatoria(3,20);
                    $apellido1A=Persona::generarCadenaAleatoria(3,20);
                    $apellido2A=Persona::generarCadenaAleatoria(3,20);
                    $nacimientoA=Persona::generarNacimientoAleatorio('1/1/1940','1/1/2006');
                    $doiA=Persona::generarDOIAleatorio();
                    $direccionA=Persona::generarCadenaAleatoria(10,30);
                    $telefonosA=Persona::generarTelefonosAleatorios(3);
                    $sexoA=Persona::generarSexoAleatorio();

                    $anhosServicioA=mt_rand(0,40); // Es cierto que podría no ser coherente con el año de nacimiento

                    $row=array($nombreA,$apellido1A,$apellido2A,$nacimientoA,$doiA,$direccionA,$telefonosA,$sexoA,$anhosServicioA);

                    $conserje=new Conserje($row);
                    return $conserje;
                }

            }

            /* Definimos la clase PersonalLimpieza. Totalmente paralela a Administrativo y Conserje */
            class PersonalLimpieza extends EmpleadoNoDocente
            {
                private static $numPersonalLimpieza=0;
                public function __construct() // Implementamos dos versiones
                                              // 1ª: Sin argumentos
                                              // 2ª: Con un argumento que consiste en una lista con las propiedades ordenadas (padre y luego hijo)
                {
                    $num = func_num_args(); //guardamos el número de argumentos
                    switch ($num) 
                    {
                        case 0:
                            parent::__construct();
                        break;
                        case 1:
                            parent::__construct(func_get_arg(0));
                    }

                    self::$numPersonalLimpieza++;
                }


                public function __destruct() 
                {
                    self::$numPersonalLimpieza--;
                }

                public static function numeroObjetosCreado()
                {
                    return self::$numPersonalLimpieza;
                }

                public function __toString()
                {
                    $resultado= parent::__toString();
                    $resultado.="\t\t\tCLASE HIJO: ".self::class  .PHP_EOL;
                    
                    return $resultado;
                }

                public function trabajar()
                {
                    $resultado='Soy ';
                    if($this->sexo =='masculino')
                        $resultado.="un limpiador ";
                    else
                        $resultado.="una limpiadora ";
                    $resultado.="con " . $this->anhosServicio . " años de servicio.".PHP_EOL;
                    return $resultado;
                }
            
                public static function generarAlAzar()
                {
                    $nombreA=Persona::generarCadenaAleatoria(3,20);
                    $apellido1A=Persona::generarCadenaAleatoria(3,20);
                    $apellido2A=Persona::generarCadenaAleatoria(3,20);
                    $nacimientoA=Persona::generarNacimientoAleatorio('1/1/1940','1/1/2006');
                    $doiA=Persona::generarDOIAleatorio();
                    $direccionA=Persona::generarCadenaAleatoria(10,30);
                    $telefonosA=Persona::generarTelefonosAleatorios(3);
                    $sexoA=Persona::generarSexoAleatorio();

                    $anhosServicioA=mt_rand(0,40); // Es cierto que podría no ser coherente con el año de nacimiento

                    $row=array($nombreA,$apellido1A,$apellido2A,$nacimientoA,$doiA,$direccionA,$telefonosA,$sexoA,$anhosServicioA);

                    $personalLimpieza=new PersonalLimpieza($row);
                    return $personalLimpieza;
                }    
            }


        /* Definimos la clase EmpleadoDocente. Podría haberle llamado Profesor, pero por simetría me pareció mejor EmpleadoDocente */
        class EmpleadoDocente extends Empleado
        {
            /* Definimos un array constante para guardar los diferentes cargos */
            public const CARGOS=array('ninguno','dirección', 'secretariado', 'jefatura estudios diurno', 'jefatura estudios personas adultas', 'vicedirección');
            
            /* Definimos la variable para guardar el número de profesores creados */
            private static $numEmpleadosDocentes=0;

            /* Definimos las varibles con los contenidos específicos de esta clase */
            private $materias;
            private $cargo;

            /* Definimos setters y getters para esas propiedades específicas */
            public function getMaterias()
            {
               return $this->materias;
            }
            public function setMaterias($mat)
            {
                $this->materias=$mat;
            }

            public function getCargo()
            {
               return $this->cargo;
            }
            public function setCargo($car)
            {
                $this->cargo=$car;
            }


            /* Definimos el constructor. Seguimos con el modelo de llamada al constructor de su padre, añadiendo el contenido específico */
            public function __construct() // Implementamos dos versiones
                                          // 1ª: Sin argumentos
                                          // 2ª: Con un argumento que consiste en una lista con las propiedades ordenadas (padre y luego hijo)
            {
                $num = func_num_args(); //guardamos el número de argumentos
                switch ($num) 
                {
                    case 0:
                        parent::__construct();
                    break;
                    case 1:
                        parent::__construct(func_get_arg(0));
                        $this->materias= func_get_arg(0)[9];
                        $this->cargo= func_get_arg(0)[10];
                }

                self::$numEmpleadosDocentes++;
            }

            /* Definimos el destructor actualizando la cuenta de objetos creados */
            public function __destruct() 
            {
                self::$numEmpleadosDocentes--;
            }

            /* Definimos la función para devolve el número de profesores creados */
            public static function numeroObjetosCreado()
            {
                return self::$numEmpleadosDocentes;
            }
            
            /* Definimos la función toString */
            public function __toString()
            {
                $resultado= parent::__toString();
                $resultado.="\t\tCLASE HIJO: ".self::class  .PHP_EOL;
                $resultado.="\t\t"."Materias que imparte: ";
                foreach($this->materias as $materia)
                    $resultado.=$materia ." ";
                $resultado.=PHP_EOL;
                $resultado.="\t\t"."Cargo: " . $this->cargo .PHP_EOL;

                return $resultado;
            }

            /* Creamos la función trabajar con contenido específico de la clase */
            public function trabajar()
            {
                $resultado='Soy ';
                if($this->sexo =='masculino')
                    $resultado.="un profesor ";
                else
                    $resultado.="una profesora ";
                $resultado.="con " . $this->anhosServicio . " años de servicio. ";
                if($this->cargo =='ninguno')
                    $resultado.="No tengo ningún cargo e ";
                else
                    $resultado.="Tengo un cargo en ".  $this->cargo ." e ";
                $resultado.="imparto las materias:".PHP_EOL;
                foreach($this->materias as $materia)
                    $resultado.="\t".$materia .".".PHP_EOL;

                return $resultado;
            }

            /* Estas función nos servirá para generar aleatoriamente. La hacemos perteneciente a la clase */
            private static function generarCadenasAleatorias($numeroMaximo)
            {
                $longitud=mt_rand(1, $numeroMaximo); // Calculamos número de materias que va a impartir como algo entre 1 y el argumento 
                $materiasA=array();    
                for($i = 0; $i < $longitud; $i++) 
                {
                    $materiasA[]=Persona::generarCadenaAleatoria(5,20);
                }
                return $materiasA;
            }

            /* Creamos la función generarAlAzar */
            public static function generarAlAzar()
            {
                /* Parte perteneciente a Persona */
                $nombreA=Persona::generarCadenaAleatoria(3,20);
                $apellido1A=Persona::generarCadenaAleatoria(3,20);
                $apellido2A=Persona::generarCadenaAleatoria(3,20);
                $nacimientoA=Persona::generarNacimientoAleatorio('1/1/1940','1/1/2006');
                $doiA=Persona::generarDOIAleatorio();
                $direccionA=Persona::generarCadenaAleatoria(10,30);
                $telefonosA=Persona::generarTelefonosAleatorios(3);
                $sexoA=Persona::generarSexoAleatorio();

                /* Parte perteneciente a Empleado */
                $anhosServicioA=mt_rand(0,40); // Es cierto que podría no ser coherente con el año de nacimiento

                /* Parte perteneciente a EmpleadoDocente */
                $materiasA=EmpleadoDocente::generarCadenasAleatorias(6); // Decidimos que no va a impartir más de 6 materias
                $cargoA=EmpleadoDocente::CARGOS[mt_rand(0,count(EmpleadoDocente::CARGOS)-1)];

                /* Creamos un array con todos los datos para pasar al constructor */
                $row=array($nombreA,$apellido1A,$apellido2A,$nacimientoA,$doiA,$direccionA,$telefonosA,$sexoA,$anhosServicioA,$materiasA,$cargoA);

                $docente=new EmpleadoDocente($row);
                return $docente;
            }
        }

    /* Creamos la clase Alumno, que vuelve a ser abstracta */
    abstract class Alumno extends Persona
    {
        /* Definimos la variable para guardar el número total de alumnos (de cualquier tipo) que se crean */
        private static $numAlumnos=0;

        /* Definimos las variables para guardar el contenido específico de la clase */
        protected $curso;
        protected $grupo;

        /* Definimos setters y getters */
        public function setCurso($cur)
        {
            $this->curso=$cur;
        }
        public function getCurso()
        {
           return $this->curso;
        }

        public function setGrupo($gru)
        {
            $this->grupo=$gru;
        }
        public function getGrupo()
        {
           return $this->grupo;
        }

        /* Implementamos el constructor. Como siempre el mismo sistema de llamar al de su padre y completar
        el contenido específico con los datos que se han pasado */
        public function __construct() // Implementamos dos versiones
                                      // 1ª: Sin argumentos
                                      // 2ª: Con un argumento que consiste en una lista con las propiedades ordenadas (padre y luego hijo)
        {
            $num = func_num_args(); //guardamos el número de argumentos
            switch ($num) 
            {
                case 0:
                    parent::__construct();
                break;
                case 1:
                    parent::__construct(func_get_arg(0));
                    $this->curso= func_get_arg(0)[8];
                    $this->grupo= func_get_arg(0)[9];
            }

            self::$numAlumnos++;
        }

        /* Definimos el destructor */
        public function __destruct() 
        {
            self::$numAlumnos--;
        }

        /* Como es una clase abstracta tenemos que entender que esta función devuelve el número 
        de objetos creados pertenecientes a subclases que heredan de esta. Objetos puros de esta
        clase no puede haber ninguno. De todas formas, es útil para llevar las cuentas */
        public static function numeroObjetosCreado()
        {
            return self::$numAlumnos;
        }

        /* Definimos la función toString llamando al de su padre y completando con el contenido específico */
        public function __toString()
        {
            $resultado= parent::__toString();
            $resultado.="\tCLASE HIJO: ".self::class  .PHP_EOL;
            $resultado.="\t"."Curso: " . $this->curso .PHP_EOL;
            $resultado.="\t"."Grupo: " . $this->grupo .PHP_EOL;         
            return $resultado;
        }

        /* Como la clase es abstracta y la tarea nos dice que tienen que estar en todas las clases, no
        queda más remedio que hacer abstractas también las siguientes funciones. Si se definiesen, nunca se podría llamar
        a través de un objeto de esta clase porque éstos no pueden existir*/
        abstract public function trabajar();
        /* Pero la siguiente parece además más propia de asignarla a la clase que al objeto, por eso la hacemos static */
        abstract public static function generarAlAzar();
    }

        /* Definimos la clase AlumnoESO. Vuelve a no ser abstracta */
        class AlumnoESO extends Alumno
        {
            /* Definimos la variable para guardar el número de objetos creados de este tipo */
            private static $numAlumnosESO=0;

            /* Definimos el contructor */
            public function __construct() // Implementamos dos versiones
                                          // 1ª: Sin argumentos
                                          // 2ª: Con un argumento que consiste en una lista con las propiedades ordenadas (padre y luego hijo)
            {
                $num = func_num_args(); //guardamos el número de argumentos
                switch ($num) 
                {
                    case 0:
                        parent::__construct();
                    break;
                    case 1:
                        parent::__construct(func_get_arg(0));
                }

                self::$numAlumnosESO++;
            }

            /* Definimos el destructor */
            public function __destruct() 
            {
                self::$numAlumnosESO--;
            }

            /* Función que devuelve el número de objetos creados de este tipo */
            public static function numeroObjetosCreado()
            {
                return self::$numAlumnosESO;
            }

            /* Definimos la función toString completando la información que obtenemos de la clase padre */
            public function __toString()
            {
                $resultado= parent::__toString();
                $resultado.="\t\tCLASE HIJO: ".self::class  .PHP_EOL;
      
                return $resultado;
            }

            /* Implementamos la función trabajar particularizando para esta clase */
            public function trabajar()
            {
                $resultado='Soy ';
                if($this->sexo =='masculino')
                    $resultado.="un estudiante ";
                else
                    $resultado.="una estudiante ";
                $resultado.="de la ESO y estoy estudiando el curso " . $this->curso . " grupo ".$this->grupo .".".PHP_EOL;
    
                return $resultado;
            }

            /* Creamos la función generarAlAzar con el mismo modelo de siempre. Se trata de crear una cadena con todos
            los datos que necesitamos que luego pasamos al contructor de esta clase, que a su vez ya se encarga de mandar
            la información al contructor de su padre, y éste al de su respectivo, etc. */
            public static function generarAlAzar()
            {
                /* Parte para la Persona */
                $nombreA=Persona::generarCadenaAleatoria(3,20);
                $apellido1A=Persona::generarCadenaAleatoria(3,20);
                $apellido2A=Persona::generarCadenaAleatoria(3,20);
                $nacimientoA=Persona::generarNacimientoAleatorio('1/1/1940','1/1/2006');
                $doiA=Persona::generarDOIAleatorio();
                $direccionA=Persona::generarCadenaAleatoria(10,30);
                $telefonosA=Persona::generarTelefonosAleatorios(3);
                $sexoA=Persona::generarSexoAleatorio();

                /* Parte para el Alumno */
                $cursoA=Persona::generarCadenaAleatoria(5,20);
                $grupoA=Persona::generarCadenaAleatoria(1,1);

                $row=array($nombreA,$apellido1A,$apellido2A,$nacimientoA,$doiA,$direccionA,$telefonosA,$sexoA,$cursoA,$grupoA);

                $alumnoEso=new AlumnoESO($row);
                return $alumnoEso;
            }   
        }

        /* Creamos la clase AlumnoBAC. Es totalmente paralela a la anterior */
        class AlumnoBAC extends Alumno
        {
            private static $numAlumnosBAC=0;
            public function __construct() // Implementamos dos versiones
                                          // 1ª: Sin argumentos
                                          // 2ª: Con un argumento que consiste en una lista con las propiedades ordenadas (padre y luego hijo)
            {
                $num = func_num_args(); //guardamos el número de argumentos
                switch ($num) 
                {
                    case 0:
                        parent::__construct();
                    break;
                    case 1:
                        parent::__construct(func_get_arg(0));
                }

                self::$numAlumnosBAC++;
            }


            public function __destruct() 
            {
                self::$numAlumnosBAC--;
            }

            public static function numeroObjetosCreado()
            {
                return self::$numAlumnosBAC;
            }

            public function __toString()
            {
                $resultado= parent::__toString();
                $resultado.="\t\tCLASE HIJO: ".self::class  .PHP_EOL;
      
                return $resultado;
            }

            public function trabajar()
            {
                $resultado='Soy ';
                if($this->sexo =='masculino')
                    $resultado.="un estudiante ";
                else
                    $resultado.="una estudiante ";
                $resultado.="de BAC y estoy estudiando el curso " . $this->curso ." grupo ". $this->grupo .".".PHP_EOL;
    
                return $resultado;
            }

            public static function generarAlAzar()
            {
                $nombreA=Persona::generarCadenaAleatoria(3,20);
                $apellido1A=Persona::generarCadenaAleatoria(3,20);
                $apellido2A=Persona::generarCadenaAleatoria(3,20);
                $nacimientoA=Persona::generarNacimientoAleatorio('1/1/1940','1/1/2006');
                $doiA=Persona::generarDOIAleatorio();
                $direccionA=Persona::generarCadenaAleatoria(10,30);
                $telefonosA=Persona::generarTelefonosAleatorios(3);
                $sexoA=Persona::generarSexoAleatorio();

                $cursoA=Persona::generarCadenaAleatoria(5,20);
                $grupoA=Persona::generarCadenaAleatoria(1,1);

                $row=array($nombreA,$apellido1A,$apellido2A,$nacimientoA,$doiA,$direccionA,$telefonosA,$sexoA,$cursoA,$grupoA);

                $alumnoBac=new AlumnoBAC($row);
                return $alumnoBac;
            } 
        }

        /* Creamos la case AlumnoFP. Es casi paralela a alumnoESO y alumnoBAC. Lo único que añade es cicloFormativo */
        class AlumnoFP extends Alumno
        {
            private static $numAlumnosFP=0;
            private $cicloFormativo;

            public function setCicloFormativo($ciclo)
            {
                $this->cicloFormativo=$ciclo;
            }
            public function getCicloFormativo()
            {
               return $this->cicloFormativo;
            }

            public function __construct() // Implementamos dos versiones
                                          // 1ª: Sin argumentos
                                          // 2ª: Con un argumento que consiste en una lista con las propiedades ordenadas (padre y luego hijo)
            {
                $num = func_num_args(); //guardamos el número de argumentos
                switch ($num) 
                {
                    case 0:
                        parent::__construct();
                    break;
                    case 1:
                        parent::__construct(func_get_arg(0));
                        $this->cicloFormativo= func_get_arg(0)[10];

                }

                self::$numAlumnosFP++;
            }


            public function __destruct() 
            {
                self::$numAlumnosFP--;
            }            

            public static function numeroObjetosCreado()
            {
                return self::$numAlumnosFP;
            }

            public function __toString()
            {
                $resultado= parent::__toString();
                $resultado.="\t\tCLASE HIJO: ".self::class  .PHP_EOL;
                $resultado.="\t\t"."Ciclo formativo: " . $this->cicloFormativo .PHP_EOL;
      
                return $resultado;
            }

            public function trabajar()
            {
                $resultado='Soy ';
                if($this->sexo =='masculino')
                    $resultado.="un estudiante ";
                else
                    $resultado.="una estudiante ";
                $resultado.="del ciclo formativo " . $this->cicloFormativo . " y estoy estudiando el curso " . $this->curso . " grupo ".$this->grupo .".".PHP_EOL;
    
                return $resultado;
            }
            public static function generarAlAzar()
            {
                $nombreA=Persona::generarCadenaAleatoria(3,20);
                $apellido1A=Persona::generarCadenaAleatoria(3,20);
                $apellido2A=Persona::generarCadenaAleatoria(3,20);
                $nacimientoA=Persona::generarNacimientoAleatorio('1/1/1940','1/1/2006');
                $doiA=Persona::generarDOIAleatorio();
                $direccionA=Persona::generarCadenaAleatoria(10,30);
                $telefonosA=Persona::generarTelefonosAleatorios(3);
                $sexoA=Persona::generarSexoAleatorio();

                $cursoA=Persona::generarCadenaAleatoria(5,20);
                $grupoA=Persona::generarCadenaAleatoria(1,1);

                $cicloA=Persona::generarCadenaAleatoria(5,20);

                $row=array($nombreA,$apellido1A,$apellido2A,$nacimientoA,$doiA,$direccionA,$telefonosA,$sexoA,$cursoA,$grupoA,$cicloA);

                $alumnoFp=new AlumnoFP($row);
                return $alumnoFp;
            }

        }

