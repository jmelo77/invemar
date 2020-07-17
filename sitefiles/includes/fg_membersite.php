<?PHP
/*
    Registration/Login script from HTML Form Guide
    V1.0

    This program is free software published under the
    terms of the GNU Lesser General Public License.
    http://www.gnu.org/copyleft/lesser.html
    

This program is distributed in the hope that it will
be useful - WITHOUT ANY WARRANTY; without even the
implied warranty of MERCHANTABILITY or FITNESS FOR A
PARTICULAR PURPOSE.

For updates, please visit:
http://www.html-form-guide.com/php-form/php-registration-form.html
http://www.html-form-guide.com/php-form/php-login-form.html

*/
require_once("class.phpmailer.php");
require_once("formvalidator.php");

class FGMembersite
{
    var $admin_email;
    var $from_address;
    
    var $username;
    var $pwd;
    var $database;
    var $tablename;
    var $connection;
    var $rand_key;
    
    var $error_message;
    
    //-----Initialization -------
    function FGMembersite()
    {
        $this->sitename = 'bedviajes.com';
        $this->rand_key = '0iQx5oBk66oVZep';
    }
    
    function InitDB($host,$uname,$pwd,$database,$tablename)
    {
        $this->db_host  = $host;
        $this->username = $uname;
        $this->pwd  = $pwd;
        $this->database  = $database;
        $this->tablename = $tablename;
        
    }
    function SetAdminEmail($email)
    {
        $this->admin_email = $email;
    }
    
    function SetWebsiteName($sitename)
    {
        $this->sitename = $sitename;
    }
    
    function SetRandomKey($key)
    {
        $this->rand_key = $key;
    }
    
    //-------Main Operations ----------------------
    function RegisterUser()
    {
        if(!isset($_POST['submitted']))
        {
           return false;
        }
        
        $formvars = array();
        
        if(!$this->ValidateRegistrationSubmission())
        {
            return false;
        }
        
        $this->CollectRegistrationSubmission($formvars);
        
        if(!$this->SaveToDatabase($formvars))
        {
            return false;
        }
        
        if(!$this->SendUserConfirmationEmail($formvars))
        {
            return false;
        }
		
        $this->SendAdminIntimationEmail($formvars);
        
        return true;
    }

    function ConfirmUser()
    {
        if(empty($_GET['code'])||strlen($_GET['code'])<=10)
        {
            $this->HandleError("Por favor, indique el codigo de confirmacion.");
            return false;
        }
        $user_rec = array();
        if(!$this->UpdateDBRecForConfirmation($user_rec))
        {
            return false;
        }
        
        $this->SendUserWelcomeEmail($user_rec);
        
        $this->SendAdminIntimationOnRegComplete($user_rec);
        
        return true;
    }    
    
    function Login()
    {
        if(empty($_POST['username']))
        {
            $this->HandleError("Nombre de usuario esta vacio!");
            return false;
        }
        
        if(empty($_POST['password']))
        {
            $this->HandleError("Contraseña está vacío!");
            return false;
        }
        
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        
        if(!isset($_SESSION)){ session_start(); }
        if(!$this->CheckLoginInDB($username,$password))
        {
            return false;
        }
        
        $_SESSION[$this->GetLoginSessionVar()] = $username;
        
        return true;
    }
    
    function CheckLogin()
    {
         if(!isset($_SESSION)){ session_start(); }

         $sessionvar = $this->GetLoginSessionVar();
         
         if(empty($_SESSION[$sessionvar]))
         {
            return false;
         }
         return true;
    }
    
    function User_Name()
    {
        return isset($_SESSION['user_name'])?$_SESSION['user_name']:'';
    }
		
    function UserFullName()
    {
        return isset($_SESSION['name_of_user'])?$_SESSION['name_of_user']:'';
    }
    
    function UserEmail()
    {
        return isset($_SESSION['email_of_user'])?$_SESSION['email_of_user']:'';
    }
	
    function UserProv()
    {
        return isset($_SESSION['user_prov'])?$_SESSION['user_prov']:'';
    }
	
    
    function LogOut()
    {
        session_start();
 /*       
        $sessionvar = $this->GetLoginSessionVar();
        
        $_SESSION[$sessionvar]=NULL;
        
        unset($_SESSION[$sessionvar]);
*/
	    session_unset();		
    }
    
    function EmailResetPasswordLink()
    {
        if(empty($_POST['email']))
        {
            $this->HandleError("Email esta vacio!");
            return false;
        }
		
		
        if(empty($_POST['password']))
        {
            $this->HandleError("La contraseña esta vacia!");
            return false;
        }
		
		
        $user_rec = array();
        if(false === $this->GetUserFromEmail($_POST['email'], $user_rec))
        {
            return false;
        }
        if(false === $this->SendResetPasswordLink($user_rec))
        {
            return false;
        }
        return true;
    }
    
    function ResetPassword()
    {
        if(empty($_GET['email']))
        {
            $this->HandleError("Email esta vacio!");
            return false;
        }
		
		
        if(empty($_GET['password']))
        {
            $this->HandleError("Contraseña esta vacia!");
            return false;
        }		
		
		
        if(empty($_GET['code']))
        {
            $this->HandleError("Codigo de restablecimiento de contraseña esta vacio!");
            return false;
        }
        $email = trim($_GET['email']);
		
		
		$password = trim($_GET['password']);
		
		
        $code = trim($_GET['code']);
        
        if($this->GetResetPasswordCode($email) != $code)
        {
            $this->HandleError("Código de Restablecimiento Errado!");
            return false;
        }
        
        $user_rec = array();
        if(!$this->GetUserFromEmail($email,$user_rec))
        {
            return false;
        }
        
        //$new_password = $this->ResetUserPasswordInDB($user_rec);
		$new_password = $this->ResetUserPasswordInDB($user_rec,$password);
		
        if(false === $new_password || empty($new_password))
        {
            $this->HandleError("Error actualizando nueva contraseña");
            return false;
        }
        
        if(false == $this->SendNewPassword($user_rec,$new_password))
        {
            $this->HandleError("Error al enviar nueva conraseña");
            return false;
        }
        return true;
    }
    
    function ChangePassword()
    {
        if(!$this->CheckLogin())
        {
            $this->HandleError("Sin Conectar!");
            return false;
        }
        
        if(empty($_POST['oldpwd']))
        {
            $this->HandleError("No ha iniciado sesion!");
            return false;
        }
        if(empty($_POST['newpwd']))
        {
            $this->HandleError("Nueva contraseña esta vacia!");
            return false;
        }
        
        $user_rec = array();
        if(!$this->GetUserFromEmail($this->UserEmail(),$user_rec))
        {
            return false;
        }
        
        $pwd = trim($_POST['oldpwd']);
        
        if($user_rec['password'] != md5($pwd))
        {
            $this->HandleError("La antigua contraseña no coincide!");
            return false;
        }
        $newpwd = trim($_POST['newpwd']);
        
        if(!$this->ChangePasswordInDB($user_rec, $newpwd))
        {
            return false;
        }
        return true;
    }
    
    //-------Public Helper functions -------------
    function GetSelfScript()
    {
        return htmlentities($_SERVER['PHP_SELF']);
    }    
    
    function SafeDisplay($value_name)
    {
        if(empty($_POST[$value_name]))
        {
            return'';
        }
        return htmlentities($_POST[$value_name]);
    }
    
    function RedirectToURL($url)
    {
        header("Location: $url");
        exit;
    }
    
    function GetSpamTrapInputName()
    {
        return 'sp'.md5('KHGdnbvsgst'.$this->rand_key);
    }
    
    function GetErrorMessage()
    {
        if(empty($this->error_message))
        {
            return '';
        }
        $errormsg = nl2br(htmlentities($this->error_message));
        return $errormsg;
    }    
    //-------Private Helper functions-----------
    
    function HandleError($err)
    {
        $this->error_message .= $err;
    }
    
    function HandleDBError($err)
    {
        $this->HandleError($err."\r\n mysqlerror:".mysql_error());
    }
    
    function GetFromAddress()
    {
        if(!empty($this->from_address))
        {
            return $this->from_address;
        }

        $host = $_SERVER['SERVER_NAME'];

        $from ="noresponder@$host";
        return $from;
    } 
    
    function GetLoginSessionVar()
    {
        $retvar = md5($this->rand_key);
        $retvar = 'usr_'.substr($retvar,0,10);
        return $retvar;
    }
    
    function CheckLoginInDB($username,$password)
    {
        if(!$this->DBLogin())
        {
            $this->HandleError("Database login failed!");
            return false;
        }          
        $username = $this->SanitizeForSQL($username);
        $pwdmd5 = md5($password);
        $qry = "Select name, email, username, id_prov from $this->tablename where username='$username' and password='$pwdmd5' and confirmcode='y' and nivel='1'";
        
        $result = mysql_query($qry,$this->connection);
        
        if(!$result || mysql_num_rows($result) <= 0)
        {
            $this->HandleError("Error de Login. El nombre de usuario o contraseña no coincide.");
            return false;
        }
        
        $row = mysql_fetch_assoc($result);
        		
        $_SESSION['user_name']  = $row['username'];        
        $_SESSION['name_of_user']  = $row['name'];
        $_SESSION['email_of_user'] = $row['email'];
        $_SESSION['user_prov']  = $row['id_prov']; 		
		
        
        return true;
    }
    
    function UpdateDBRecForConfirmation(&$user_rec)
    {
        if(!$this->DBLogin())
        {
            $this->HandleError("Base de datos de inicio de sesión fallo!");
            return false;
        }   
        $confirmcode = $this->SanitizeForSQL($_GET['code']);
        
        $result = mysql_query("Select name, email from $this->tablename where confirmcode='$confirmcode'",$this->connection);   
        if(!$result || mysql_num_rows($result) <= 0)
        {
            $this->HandleError("Codigo de confirmacion incorrecto.");
            return false;
        }
        $row = mysql_fetch_assoc($result);
        $user_rec['name'] = $row['name'];
        $user_rec['email']= $row['email'];
        
        $qry = "Update $this->tablename Set confirmcode='y' Where  confirmcode='$confirmcode'";
        
        if(!mysql_query( $qry ,$this->connection))
        {
            $this->HandleDBError("Error al insertar datos en la tabla\nquery:$qry");
            return false;
        }      
        return true;
    }
    
    function ResetUserPasswordInDB($user_rec,$new_password)
    {
      //$new_password = substr(md5(uniqid()),0,10);
        
        if(false == $this->ChangePasswordInDB($user_rec,$new_password))
        {
            return false;
        }
        return $new_password;
    }
    
    function ChangePasswordInDB($user_rec, $newpwd)
    {
        $newpwd = $this->SanitizeForSQL($newpwd);
        
        $qry = "Update $this->tablename Set password='".md5($newpwd)."' Where id_user=".$user_rec['id_user']."";
        
        if(!mysql_query( $qry ,$this->connection))
        {
            $this->HandleDBError("Error al actualizar contraseña \nquery:$qry");
            return false;
        }     
        return true;
    }
    
    function GetUserFromEmail($email,&$user_rec)
    {
        if(!$this->DBLogin())
        {
            $this->HandleError("Base de datos de inicio de sesion fallido!");
            return false;
        }   
        $email = $this->SanitizeForSQL($email);
        
        $result = mysql_query("Select * from $this->tablename where email='$email'",$this->connection);  

        if(!$result || mysql_num_rows($result) <= 0)
        {
            $this->HandleError("No existe un usuario con correo electronico: $email");
            return false;
        }
        $user_rec = mysql_fetch_assoc($result);

        
        return true;
    }
    
    function SendUserWelcomeEmail(&$user_rec)
    {
        $mailer = new PHPMailer();
        
        $mailer->CharSet = 'utf-8';
        
        $mailer->AddAddress($user_rec['email'],$user_rec['name']);
        
        $mailer->Subject = "Bienvenido a ".$this->sitename;

        $mailer->From = $this->GetFromAddress();        
        
        $mailer->Body ="Hola ".$user_rec['name']."\r\n\r\n".
        "Bienvenido! Su registro con ".$this->sitename." esta completo.\r\n".
        "\r\n".
        "Saludos,\r\n".
        "Webmaster\r\n".
        $this->sitename;

        if(!$mailer->Send())
        {
            $this->HandleError("Fallo al enviar usuario al e-mail de bienvenida.");
            return false;
        }
        return true;
    }
    
    function SendAdminIntimationOnRegComplete(&$user_rec)
    {
        if(empty($this->admin_email))
        {
            return false;
        }
        $mailer = new PHPMailer();
        
        $mailer->CharSet = 'utf-8';
        
        $mailer->AddAddress($this->admin_email);
        
        $mailer->Subject = "Registro Completo: ".$user_rec['name'];

        $mailer->From = $this->GetFromAddress();         
        
        $mailer->Body ="Un nuevo usuario registrado en ".$this->sitename."\r\n".
        "Nombre: ".$user_rec['name']."\r\n".
        "Email: ".$user_rec['email']."\r\n";
        
        if(!$mailer->Send())
        {
            return false;
        }
        return true;
    }
    
    function GetResetPasswordCode($email)
    {
       return substr(md5($email.$this->sitename.$this->rand_key),0,10);
    }
    
    function SendResetPasswordLink($user_rec)
    {
        $email = $user_rec['email'];
		
		
		$password = $_POST['password'];
        
		
        $mailer = new PHPMailer();
        
        $mailer->CharSet = 'utf-8';
        
        $mailer->AddAddress($email,$user_rec['name']);
        
        $mailer->Subject = "Su solicitud de restablecimiento de contrasena en ".$this->sitename;

        $mailer->From = $this->GetFromAddress();
        
        $link = $this->GetAbsoluteURLFolder().
                '/resetpwd.php?email='.
                urlencode($email).'&password='.urlencode($password).'&code='.
                urlencode($this->GetResetPasswordCode($email));

        $mailer->Body ="Hola ".$user_rec['name']."\r\n\r\n".
        "Hubo una solicitud para restablecer la contrasena de ".$this->sitename."\r\n".
        "Por favor, haz clic en el enlace de abajo para completar la solicitud: \r\n".$link."\r\n".
        "Saludos,\r\n".
        "Webmaster\r\n".
        $this->sitename;
        
        if(!$mailer->Send())
        {
            return false;
        }
        return true;
    }
    
    function SendNewPassword($user_rec, $new_password)
    {
        $email = $user_rec['email'];
        
        $mailer = new PHPMailer();
        
        $mailer->CharSet = 'utf-8';
        
        $mailer->AddAddress($email,$user_rec['name']);
        
        $mailer->Subject = "Su nueva contrasena para ".$this->sitename;

        $mailer->From = $this->GetFromAddress();
        
        $mailer->Body ="Hola ".$user_rec['name']."\r\n\r\n".
        "Su contrasena se restablecio correctamente. ".
        "Aqui esta su nombre de usuario actualizado:\r\n".
        "Usuario:".$user_rec['username']."\r\n".
        "Contrasena:$new_password\r\n".
        "\r\n".
        "Entre aqui: ".$this->GetAbsoluteURLFolder()."/login.php\r\n".
        "\r\n".
        "Saludos,\r\n".
        "Webmaster\r\n".
        $this->sitename;
        
        if(!$mailer->Send())
        {
            return false;
        }
        return true;
    }    
    
    function ValidateRegistrationSubmission()
    {
        //This is a hidden input field. Humans won't fill this field.
        if(!empty($_POST[$this->GetSpamTrapInputName()]) )
        {
            //The proper error is not given intentionally
            $this->HandleError("Automated submission prevention: case 2 failed");
            return false;
        }
        
        $validator = new FormValidator();
        $validator->addValidation("name","req","Por favor llene un Nombre");
        $validator->addValidation("email","email","Escriba un e-mail valido");
        $validator->addValidation("email","req","Por favor llene un Email");
        //$validator->addValidation("username","req","Por favor llene un Nombre de Usuario");
		$validator->addValidation("username","req","Por favor llene un Email");
        $validator->addValidation("password","req","Por favor llene una Contraseña");

        
        if(!$validator->ValidateForm())
        {
            $error='';
            $error_hash = $validator->GetErrors();
            foreach($error_hash as $inpname => $inp_err)
            {
                $error .= $inpname.':'.$inp_err."\n";
            }
            $this->HandleError($error);
            return false;
        }        
        return true;
    }
    
    function CollectRegistrationSubmission(&$formvars)
    {
        $formvars['name'] = $this->Sanitize($_POST['name']);
        $formvars['email'] = $this->Sanitize($_POST['email']);
        $formvars['username'] = $this->Sanitize($_POST['username']);
        $formvars['password'] = $this->Sanitize($_POST['password']);
        $formvars['idprov'] = $this->Sanitize($_POST['idprov']);		
    }
    
    function SendUserConfirmationEmail(&$formvars)
    {
        $mailer = new PHPMailer();
        
        $mailer->CharSet = 'utf-8';
        
        $mailer->AddAddress($formvars['email'],$formvars['name']);
        
        $mailer->Subject = "Tu registro con ".$this->sitename;

        $mailer->From = $this->GetFromAddress();        
        
        $confirmcode = $formvars['confirmcode'];
        
        $confirm_url = $this->GetAbsoluteURLFolder().'/confirmreg.php?code='.$confirmcode;
        
        $mailer->Body ="Hola ".$formvars['name']."\r\n\r\n".
        "Gracias por registrarte con ".$this->sitename."\r\n".
		/*"Usuario: ".$formvars['username']."\r\n".*/
		"Usuario: ".$formvars['email']."\r\n".
		"Contrasena: ".$formvars['password']."\r\n".		
        /*"Por favor, haga clic en el siguiente enlace para confirmar su registro.\r\n".
        "$confirm_url\r\n".*/
        "\r\n".
        "Saludos,\r\n".
        "Webmaster\r\n".
        $this->sitename;

        if(!$mailer->Send())
        {
            $this->HandleError("No se ha podido enviar el e-mail de confirmación de registro.");
            return false;
        }
        return true;
    }
    function GetAbsoluteURLFolder()
    {
        $scriptFolder = (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on')) ? 'https://' : 'http://';
        $scriptFolder .= $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']);
        return $scriptFolder;
    }
    
    function SendAdminIntimationEmail(&$formvars)
    {
        if(empty($this->admin_email))
        {
            return false;
        }
        $mailer = new PHPMailer();
        
        $mailer->CharSet = 'utf-8';
        
        $mailer->AddAddress($this->admin_email);
        
        $mailer->Subject = "Nuevo registro: ".$formvars['name'];

        $mailer->From = $this->GetFromAddress();         
        
        $mailer->Body ="Un nuevo usuario registrado en ".$this->sitename."\r\n".
        "Nombre: ".$formvars['name']."\r\n".
        //"Email: ".$formvars['email']."\r\n".
		"Usuario: ".$formvars['email']."\r\n".
		"Contrasena: ".$formvars['password'];
        /*"Nombre de Usuario: ".$formvars['username'];*/
        
        if(!$mailer->Send())
        {
            return false;
        }
        return true;
    }
    
    function SaveToDatabase(&$formvars)
    {
        if(!$this->DBLogin())
        {
            $this->HandleError("Base de datos de inicio de sesion fallo!");
            return false;
        }
        if(!$this->Ensuretable())
        {
            return false;
        }
        if(!$this->IsFieldUnique($formvars,'email'))
        {
            $this->HandleError("Este Email ya esta registrado");
            return false;
        }
        
        if(!$this->IsFieldUnique($formvars,'username'))
        {
            $this->HandleError("Este nombre de usuario ya esta siendo utilizado. Por favor, pruebe con otro nombre de usuario");
            return false;
        }        
        if(!$this->InsertIntoDB($formvars))
        {
            $this->HandleError("Insercion de la Base de datos fallido!");
            return false;
        }
        return true;
    }
    
    function IsFieldUnique($formvars,$fieldname)
    {
        $field_val = $this->SanitizeForSQL($formvars[$fieldname]);
        $qry = "select username from $this->tablename where $fieldname='".$field_val."'";
        $result = mysql_query($qry,$this->connection);   
        if($result && mysql_num_rows($result) > 0)
        {
            return false;
        }
        return true;
    }
    
    function DBLogin()
    {

        $this->connection = mysql_connect($this->db_host,$this->username,$this->pwd);

        if(!$this->connection)
        {   
            $this->HandleDBError("Acceso base de datos ha fallado! Por favor, asegurese de que las credenciales de inicio de sesion DB proporcionados son correctos");
            return false;
        }
        if(!mysql_select_db($this->database, $this->connection))
        {
            $this->HandleDBError('No se pudo seleccionar la base de datos: '.$this->database.' Por favor, asegúrese de que el nombre de base de datos proporcionado es correcta');
            return false;
        }
        if(!mysql_query("SET NAMES 'UTF8'",$this->connection))
        {
            $this->HandleDBError('Error setting utf8 encoding');
            return false;
        }
        return true;
    }    
    
    function Ensuretable()
    {
        $result = mysql_query("SHOW COLUMNS FROM $this->tablename");   
        if(!$result || mysql_num_rows($result) <= 0)
        {
            return $this->CreateTable();
        }
        return true;
    }
    
    function CreateTable()
    {
        $qry = "Create Table $this->tablename (".
                "id_user INT NOT NULL AUTO_INCREMENT ,".
                "name VARCHAR( 128 ) NOT NULL ,".
                "email VARCHAR( 64 ) NOT NULL ,".
                "phone_number VARCHAR( 16 ) NOT NULL ,".
                "username VARCHAR( 16 ) NOT NULL ,".
                "password VARCHAR( 32 ) NOT NULL ,".
                "confirmcode VARCHAR(32) ,".
                "PRIMARY KEY ( id_user )".
                ")";
                
        if(!mysql_query($qry,$this->connection))
        {
            $this->HandleDBError("Error creando la tabla \nquery was\n $qry");
            return false;
        }
        return true;
    }
    
    function InsertIntoDB(&$formvars)
    {
    
        $confirmcode = $this->MakeConfirmationMd5($formvars['email']);
        
        $formvars['confirmcode'] = $confirmcode;
        
        $insert_query = 'insert into '.$this->tablename.'(
                name,
                email,
                username,
                password,
                confirmcode,
				id_prov
                )
                values
                (
                "' . $this->SanitizeForSQL($formvars['name']) . '",
                "' . $this->SanitizeForSQL($formvars['email']) . '",
                "' . $this->SanitizeForSQL($formvars['username']) . '",
                "' . md5($formvars['password']) . '",
				"y",
				"' . $this->SanitizeForSQL($formvars['idprov']) . '"
                )'; 				
				//"' . $confirmcode . '",
				     
        if(!mysql_query( $insert_query ,$this->connection))
        {
            $this->HandleDBError("Error al insertar datos a la tabla\nquery:$insert_query");
            return false;
        }        
        return true;
    }
    function MakeConfirmationMd5($email)
    {
        $randno1 = rand();
        $randno2 = rand();
        return md5($email.$this->rand_key.$randno1.''.$randno2);
    }
    function SanitizeForSQL($str)
    {
        if( function_exists( "mysql_real_escape_string" ) )
        {
              $ret_str = mysql_real_escape_string( $str );
        }
        else
        {
              $ret_str = addslashes( $str );
        }
        return $ret_str;
    }
    
 /*
    Sanitize() function removes any potential threat from the
    data submitted. Prevents email injections or any other hacker attempts.
    if $remove_nl is true, newline chracters are removed from the input.
    */
    function Sanitize($str,$remove_nl=true)
    {
        $str = $this->StripSlashes($str);

        if($remove_nl)
        {
            $injections = array('/(\n+)/i',
                '/(\r+)/i',
                '/(\t+)/i',
                '/(%0A+)/i',
                '/(%0D+)/i',
                '/(%08+)/i',
                '/(%09+)/i'
                );
            $str = preg_replace($injections,'',$str);
        }

        return $str;
    }    
    function StripSlashes($str)
    {
        if(get_magic_quotes_gpc())
        {
            $str = stripslashes($str);
        }
        return $str;
    }    
}
?>