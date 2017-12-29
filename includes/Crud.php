<DOCTYPE! HTML>
<?php
class Crud
{
    
    //public $v; variable definition should be with the access specifier.
    //Any variable defined within the constuctor should be donr with the help of this pointer.
    function __construct($servername,$username,$db)
    {
      $this->conn = new mysqli($servername, $username,"",$db);
      if ($this->conn->connect_error) 
    die("Connection failed: " . $conn->connect_error);
    
    }
    
    function deleteData($table,$del_array)  //function which accepts table name and an aaray of ids to delete
    {
        
        $bindTypes= $this->getBindType($del_array);
        $questionString=$this->getPlaceholder(count($del_array));
       
       // $query="delete from $table where id IN($this->arr)";
        
        
        $stmt=$this->conn->prepare("delete from $table where id IN($questionString);");
        
        
        call_user_func_array(array($stmt, 'bind_param'),array_merge(array($bindTypes),$this->getParams($del_array)));
        if($stmt->execute())
        {
            $ar=$stmt->affected_rows;
        return $ar;
        }
        
        
   
    }
function insert($table,$columns,$values)
{
    
    $bindTypes = $this->getBindType($values);//get the bind type for each value. eg it will return ss or sss or si etc
    
    $this->insertData($table,$columns,$values,$bindTypes);//call the master insert 
}
function insertData($table,$columns,$values,$bindTypes)//inserts the values by getting the bindtypes and placeholder values
{
    $questionMarkString = $this->getPlaceholder(count($values));//returns string with number of question marks
    $columnList = implode(',',$columns); //Get columns in a comma separated manner
    $stmt = $this->conn->prepare("INSERT INTO $table($columnList) VALUES($questionMarkString);");//Prepare the statement using the column list and question mark string
        
    call_user_func_array(array($stmt, 'bind_param'),array_merge(array($bindTypes), $this->getParams($values)));//uses to pass bind params to mysqli bind_param,$this->getParams($values) returns array with reference paramters required by bind_param
    
    $stmt->execute();//Execute the statement, if it executes correctly 
    $ar=$stmt->affected_rows;
    return $ar;
    
}
function getBindType($values)  //function to decide the datatype flow of binding
{
    $dt="";
    $ar=array();
    
     for($i=0;$i<count($values);$i++)
     {
        $dt=gettype($values[$i]);
         switch($dt)
        {
            case "integer":  //fuck off
            {
                
                $ar[]="i";
                break;
            }
            case "string":
            {
            
                $ar[]="s";
                break;
            }
            case "double":
            {
                
                $ar[]="d";
                break;
            }
            default:
            {
                
                $ar[]="b";
            }
        }
        
     }
    return implode('',$ar);//glue the parameters without spaces between them
        
    
        
}
function getPlaceHolder($count)  //returns the number of ?'s to plavce in the query based on the count
{
    $qt=array();
    for($i=0;$i<$count;$i++)
    {
        $qt[]="?";
    }
   
    return implode(",",$qt);// glue question marks using , as delimiter
}
function getParams($values)   //returns a reference of array
{
    $params= array();
    for($i = 0; $i< count($values); $i++)// loop to make the passed array as reference array
    {
        $params[$i] = &$values[$i];
        
    }
    return $params;//return referenced array
}
function getData($id,$table,$columns,$whereParam)// Retrieve data from table where whereParam is the attribute in where clause 
{
        $columnList = implode(',',$columns);
        
        $query="select $columnList from $table where $whereParam=$id";
        
        $result=mysqli_query($this->conn,$query);
        $myArray=array();
        while($row=$result->fetch_array(MYSQL_ASSOC))//Loop to copy the contents of row to an array
        {
            $myArray[]=$row;
        }
        return $myArray; // returning the resultset
        
}
    
function getJsonArray($table,$array) //returns JSON array
{
     $jsonString = '{"'.$table.'":'.json_encode($array)."}";//append table name to the json encode output
     return $jsonString;//return the final json string
    
}
function getJson($array)//returns jSon Object
{
     
     return json_encode($array);
    
}
    
    function updateData($id,$columns,$values,$table)  //returns effected no of rows after updation
    {
  
        $columnList="";
        foreach($columns as $i)
        {
            $columnList.="$i=?,";
        }
        $cL=rtrim($columnList,",");
        
        $bindTypes = $this->getBindType($values);//get the bind type for each value. eg it will return ss or sss or si etc
    
     
    
    
    $stmt = $this->conn->prepare("UPDATE $table set $cL where id=$id;");
    
   
        //$params=array_merge(array($bindTypes),$this->getParams($values));
  call_user_func_array(array($stmt, 'bind_param'),array_merge(array($bindTypes),$this->getParams($values)));//uses to pass bind params to mysqli bind_param
    if($stmt->execute())//Execute the statement, if it executes correctly 
        {
            $ar=$stmt->affected_rows;
        return $ar;
        }
       
        
    }
    function __destruct(){
        $this->conn->close();
        
    }
    
}
?>