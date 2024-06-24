 $(function () {
  'use strict';
   
    //Boite de confirmation pour tous les boutons "supprimer/annuler",il suffit de leur donner la classe"confirm"
    $('.confirm').click(function() {
       return confirm('Vous êtes sur?');
    });
});
//Ajouter un asterix pour les champs obligatoires
$('input').each(function() {
   if($(this).attr('required')==='required') {
    $(this).after("<span class='asterix'> * </span>")
    }
  });
  $('textarea').each(function() {
   if($(this).attr('required')==='required') {
    $(this).after("<span class='asterix'> * </span>")
    }
  });

//Masquer et afficher le mot de passe dans un input
var PassInput1 = $('input.password1');
var PassInput2 = $('input.password2');
var PassInput3 = $('input.password3');
$('i.show-pass1').hover(function () {
  PassInput1.attr('type','text');
   }, function() {
    PassInput1.attr('type','password');
   }
);
$('i.show-pass2').hover(function () {
  PassInput2.attr('type','text');
   }, function() {
    PassInput2.attr('type','password');
   }
);
$('i.show-pass3').hover(function () {
  PassInput3.attr('type','text');
   }, function() {
    PassInput3.attr('type','password');
   }
);



