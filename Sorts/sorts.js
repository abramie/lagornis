$(":checkbox").change(function() {
	
	if(this.checked){
		
	}else{
		
	}
  
});



function myFunction() {
  // Declare variables
  var table, tr, td, i, txtValue;
  var input_ecole, filter_ecole, checkbox_ecole, t;
  input_ecole = document.getElementById("test");
  checkbox_rarete = $("#checkbox_ecole :checkbox");
  filter_ecole = [];
  for(j = 0; j<checkbox_ecole.length; j++){
	  if(checkbox_ecole[j].checked){
		filter_ecole.push(checkbox_rarete[j].value.toUpperCase());
	  }
  }
  table = document.getElementById("table_sort");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[2];
    if (td) {
      txtValue = td.textContent || td.innerText;
      for(t = 0; t<filter_ecole.length; t++ ){
        if (txtValue.toUpperCase().indexOf(filter_ecole[t]) > -1) {
            bool_cacher = true && bool_cacher;
        } else {
            bool_cacher = false
        }
      }
      
    }
  }
}




function changement() {
  // Declare variables
  var input, filter_rarete, table, tr, td, i, txtValue, checkbox_rarete, input_nom, filter_nom, bool_cacher;
  var filter_ecole, checkbox_ecole, t, bool_ecole;
  input_nom = document.getElementById("search_texte");
  filter_nom = input_nom.value.toUpperCase();
  
  //Recupere les checkbox de rarete coché
  checkbox_rarete = $("#checkbox_rarete :checkbox");
  filter_rarete = [];
  for(j = 0; j<checkbox_rarete.length; j++){
	  if(checkbox_rarete[j].checked){
		filter_rarete.push(checkbox_rarete[j].value.toUpperCase());
	  }
  }
  
  checkbox_ecole = $("#checkbox_ecole :checkbox");
  filter_ecole = [];
  for(j = 0; j< checkbox_ecole.length; j++){
	  if(checkbox_ecole[j].checked){
		filter_ecole.push(checkbox_ecole[j].value.toUpperCase());
	  }
  }
  
  
  table = document.getElementById("table_sort");
  tr = table.getElementsByTagName("tr");
  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
	bool_cacher = true;
    bool_ecole = false;
	 //Rarete
    td = tr[i].getElementsByTagName("td")[3];
    if (td) {
        
      txtValue = td.textContent || td.innerText;
      if (filter_rarete.indexOf(txtValue.toUpperCase()) > -1) {
        bool_cacher = true && bool_cacher;
      } else {
        bool_cacher = false
      }
    }
	
	//Nom
	td = tr[i].getElementsByTagName("td")[0];
    if (td && bool_cacher) {
      txtValue = td.textContent || td.innerText;
      
      if (txtValue.toUpperCase().indexOf(filter_nom) > -1) {
        bool_cacher = true && bool_cacher;
      } else {
        bool_cacher = false
      }
    }
    
    
    td = tr[i].getElementsByTagName("td")[2];
    if (td && bool_cacher) {
      txtValue = td.textContent || td.innerText;
      for(t = 0; t<filter_ecole.length; t++ ){
        if (txtValue.toUpperCase().indexOf(filter_ecole[t]) > -1) {
            bool_ecole = true  ;
        } else {
            bool_ecole = false || bool_ecole 
        }
      }
      
      bool_cacher = bool_cacher && bool_ecole;
      
    }
	
	
	if(bool_cacher){
		tr[i].style.display = "";
	}
	else{
		tr[i].style.display = "none";
	}
	
  }
}


function ajouterElement()
{
        var Conteneur = document.getElementById('conteneur');
        if(Conteneur)
        {
                Conteneur.appendChild(creerElement(dernierElement() + 1))
        }
}


function dernierElement()
{
    var elementPattern = /^element(\d+)$/
  var Conteneur = document.getElementById('conteneur'), n = 0;
  if(Conteneur)
  {
    var elementID, elementNo;
    if(Conteneur.childNodes.length > 0)
    {
      for(var i = 0; i < Conteneur.childNodes.length; i++)
      {
        // Ici, on vérifie qu'on peut récupérer les attributs, si ce n'est pas possible, on renvoit false, sinon l'attribut
        elementID = (Conteneur.childNodes[i].getAttribute) ? Conteneur.childNodes[i].getAttribute('id') : false;
        if(elementID)
        {
          elementNo = parseInt(elementID.replace(elementPattern, '$1'));
          if(!isNaN(elementNo) && elementNo > n)
          {
            n = elementNo;
          }
        }
      }
    }
  }
  return n;
}



function supprimerElement()
{
  var deletePattern = /^delete(\d+)$/;
  var elementPattern = /^element(\d+)$/;
  var Conteneur = document.getElementById('conteneur');
  var n = parseInt(this.id.replace(deletePattern, '$1'));
  if(Conteneur && !isNaN(n))
  {
    var elementID, elementNo;
    if(Conteneur.childNodes.length > 0)
    {
      for(var i = 0; i < Conteneur.childNodes.length; i++)
      {
        elementID = (Conteneur.childNodes[i].getAttribute) ? Conteneur.childNodes[i].getAttribute('id') : false;
        if(elementID)
        {
          elementNo = parseInt(elementID.replace(elementPattern, '$1'));
          if(!isNaN(elementNo) && elementNo  == n)
          {
            Conteneur.removeChild(Conteneur.childNodes[i]);
            updateElements(); // A supprimer si tu ne veux pas la màj
            return;
          }
        }
      }
    }
  }  
}

function updateElements()
{
  var elementPattern = /^element(\d+)$/;
  var Conteneur = document.getElementById('conteneur'), n = 0;
  if(Conteneur)
  {
    var elementID, elementNo;
    if(Conteneur.childNodes.length > 0)
    {
      for(var i = 0; i < Conteneur.childNodes.length; i++)
      {
        elementID = (Conteneur.childNodes[i].getAttribute) ? Conteneur.childNodes[i].getAttribute('id') : false;
        if(elementID)
        {
          elementNo = parseInt(elementID.replace(elementPattern, '$1'));
          if(!isNaN(elementNo))
          {
            n++
            Conteneur.childNodes[i].setAttribute('id', 'element' + n);
           // document.getElementById('puissance' + elementNo).setAttribute('name', 'puissance' + n);
            document.getElementById('puissance' + elementNo).setAttribute('id', 'puissance' + n);
            document.getElementById('delete' + elementNo).setAttribute('value', 'Supprimer n°' + n);
            document.getElementById('delete' + elementNo).setAttribute('id', 'delete' + n);
            
          }
        }
      }
    }
  }
}


function creerElement(ID)
{
  var Conteneur = document.createElement('div');
  Conteneur.setAttribute('id', 'element' + ID);
  var Input = document.createElement('textarea');
  Input.setAttribute('maxlength', 5000);
  Input.setAttribute('cols',30);
  Input.setAttribute('rows', 15);
  Input.setAttribute('name', 'puissance[]');
  Input.setAttribute('id', 'puissance' + ID);
  var Delete = document.createElement('input');
  Delete.setAttribute('type', 'button');
  Delete.setAttribute('value', 'Supprimer n°' + ID + ' !');
  Delete.setAttribute('id', 'delete' + ID);
  Delete.onclick = supprimerElement;
  Conteneur.appendChild(Input);
  Conteneur.appendChild(Delete);
  return Conteneur;
}

function cocher(){
   // $(":checkbox").attr('checked', true);
    var box = $(":checkbox");
    var l = box.length;
    for(var i =0; i< l; i++){
        if(box[i].id == "ecole")
        box[i].checked = true;
    }
    changement();
    
    return false;
}
function decocher(){
    var box = $(":checkbox");
    var l = box.length;
    for(var i =0; i< l; i++){
        if(box[i].id == "ecole")
        box[i].checked = false;
    }
    changement();
    
    return false;
}





