<?php


class User_m extends CI_Model {

    var $details;

    function change_password_user( $id, $password ) {
        // Build a query to retrieve the user's details
        // based on the received username and password
        $this->db->set('password', sha1($password)); //value that used to update column  
        $this->db->where('id', $id); //which row want to upgrade  
        $this->db->update('user');  //table name

        return $id;
    }


    function validate_user( $email, $password ) {

        /*
            $salt = substr($email,1,2);
            $password = $salt.$password;
        */

        // Build a query to retrieve the user's details
        // based on the received username and password
        $this->db->from('user');
        $this->db->where('email',$email );
        $this->db->where( 'password', sha1($password) );
        $login = $this->db->get()->result();

        // The results of the query are stored in $login.
        // If a value exists, then the user account exists and is validated
        if ( is_array($login) && count($login) == 1 ) {
            // Set the users details into the $details property of this class
            $this->details = $login[0];
            // Call set_session to set the user's session vars via CodeIgniter
            $this->set_session();
            return true;
        }

        return false;
    }

    function set_session() {
        // session->set_userdata is a CodeIgniter function that
        // stores data in CodeIgniter's session storage.  Some of the values are built in
        // to CodeIgniter, others are added.  See CodeIgniter's documentation for details.
        
        $str_query = "SELECT denominacion, usuariosxsector.id_sector as id_sector FROM usuariosxsector, sectores WHERE usuariosxsector.id_sector = sectores.id_sector AND usuariosxsector.id_usuario = '". $this->details->id. "'; ";
        $query = $this->db->query($str_query);
        

        $this->session->set_userdata( array(
                'id'=>$this->details->id,
                'perfil_level'=>$this->details->perfil_level,
                'name'=> $this->details->nombre . ' ' . $this->details->apellido,
                'email'=>$this->details->email,
                'password'=>$this->details->password,
                'sectores_multiples'=>false,
                'sector_name'=>$query->result()[0]->denominacion,
                'id_sector'=>$query->result()[0]->id_sector,
/* multisectores  */ 'array_sectores' => $query->result(),
                'id-reclamo-aux' => '',
                'isLoggedIn'=>true
            )
        );

        if (count($this->session->array_sectores)>1)  $this->session->sectores_multiples = true;
    }

    function  create_new_user( $userData ) {
      $data['perfil_level'] = (int) $userData['perfil_level'];
      $data['apellido'] = $userData['lastName'];
      $data['nombre'] = $userData['firstName'];
      $data['email'] = $userData['email'];
      $data['password'] = sha1($userData['password1']);
      $this->db->insert('user',$data);
      $lastid = $this->db->insert_id();

      $data2['id_usuario'] = $lastid;
      $data2['id_sector'] = $userData['miembro_sector'];
      $this->db->insert('usuariosxsector',$data2);

      return $lastid;
    }

    function update_user_id($id,$userData){

      $data2['id_usuario'] = $id;
      $data2['id_sector'] = $userData['miembro_sector'];
      $this->db->where('id_usuario', $id);
      $this->db->update('usuariosxsector',$data2);

      $data['id'] = $id;
      $data['perfil_level'] = (int) $userData['perfil_level'];
      $data['apellido'] = $userData['lastName'];
      $data['nombre'] = $userData['firstName'];
      $data['email'] = $userData['email'];
      $data['password'] = sha1($userData['password1']);

      $this->db->where('id', $id);
      $this->db->update('user', $data);
      return $id;
    }


    function get_all__users(){
      $this->db->from('user');
      $users = $this->db->get()->result();
      return $users;  
    }

    function get_all_users_responsables(){
      $this->db->from('user');
      $this->db->join('tiporeclamo', 'tiporeclamo.id_responsable = user.id', 'inner');
      $this->db->group_by('apellido');     
      $this->db->order_by('user.apellido', 'ASC');
      $users = $this->db->get()->result();
      return $users;  
    }

    public function update_tagline( $user_id, $tagline ) {
      $data = array('tagline'=>$tagline);
      $result = $this->db->update('user', $data, array('id'=>$user_id));
      return $result;
    }

    private function getAvatar() {
      $avatar_names = array();

      foreach(glob('assets/img/avatars/*.png') as $avatar_filename){
        $avatar_filename =   str_replace("assets/img/avatars/","",$avatar_filename);
        array_push($avatar_names, str_replace(".png","",$avatar_filename));
      }

      return $avatar_names[array_rand($avatar_names)];
    }
}
