<?php
define('_MD_MESSAGE_NEWMESSAGE', 'Vous avez {0} messages.');

define('_MD_MESSAGE_FORMERROR1', 'Nom est requis.');
define('_MD_MESSAGE_FORMERROR2', 'Ajouter un nom avec 30 caract�res maximum.');
define('_MD_MESSAGE_FORMERROR3', 'Sujet est requis.');
define('_MD_MESSAGE_FORMERROR4', 'Ajouter un subjet avec 100 maximum.');
define('_MD_MESSAGE_FORMERROR5', 'Message est requis.');
define('_MD_MESSAGE_FORMERROR6', 'L\'utilisateur s�lectionn� n\'existe pas.');

define('_MD_MESSAGE_ACTIONMSG1', 'Le message n\'existe pas.');
define('_MD_MESSAGE_ACTIONMSG2', 'Vous n\'avez pas les permissions requises.');
define('_MD_MESSAGE_ACTIONMSG3', 'Le Message a �t� supprim�.');
define('_MD_MESSAGE_ACTIONMSG4', 'Echec suppression!');
define('_MD_MESSAGE_ACTIONMSG5', 'Message n\'a pu �tre envoy�.');
define('_MD_MESSAGE_ACTIONMSG6', 'Echec d\'ajout � Messages Envoy�s.');
define('_MD_MESSAGE_ACTIONMSG7', 'Message envoy�.');
define('_MD_MESSAGE_ACTIONMSG8', 'Vous n\'avez pas les permissions requises.');
define('_MD_MESSAGE_ACTIONMSG9', 'L\'utilisateur a qui vous r�pondez n\'existe pas.');

define('_MD_MESSAGE_TEMPLATE1', 'Envoyer message');
define('_MD_MESSAGE_TEMPLATE2', 'Nom Utilisateur');
define('_MD_MESSAGE_TEMPLATE3', 'Subjet');
define('_MD_MESSAGE_TEMPLATE4', 'Message');
define('_MD_MESSAGE_TEMPLATE5', 'Aper�u');
define('_MD_MESSAGE_TEMPLATE6', 'Envoyer');
define('_MD_MESSAGE_TEMPLATE7', 'Messages Envoy�s');
define('_MD_MESSAGE_TEMPLATE8', 'Nouveau Message');
define('_MD_MESSAGE_TEMPLATE9', 'A');
define('_MD_MESSAGE_TEMPLATE10', 'Date');
define('_MD_MESSAGE_TEMPLATE11', 'Message');
define('_MD_MESSAGE_TEMPLATE12', 'De');
define('_MD_MESSAGE_TEMPLATE13', 'R�pondre');
define('_MD_MESSAGE_TEMPLATE14', 'Effacer');
define('_MD_MESSAGE_TEMPLATE15', 'Bo�te de Reception');
define('_MD_MESSAGE_TEMPLATE16', 'Non-lus');
define('_MD_MESSAGE_TEMPLATE17', 'Lu');
define('_MD_MESSAGE_TEMPLATE18', 'Ordre');
define('_MD_MESSAGE_TEMPLATE19', 'Verrouiller');
define('_MD_MESSAGE_TEMPLATE20', 'D�verrouiller');
define('_MD_MESSAGE_TEMPLATE21', 'Envoyer email');
define('_MD_MESSAGE_TEMPLATE22', 'Statut');

define('_MD_MESSAGE_ADDFAVORITES', 'Ajouter � mes favoris');

define('_MD_MESSAGE_FAVORITES0', 'S�lectionnez un utilisateur pour ajouter.');
define('_MD_MESSAGE_FAVORITES1', 'Echec en ajoutant!');
define('_MD_MESSAGE_FAVORITES2', 'Ajouter');
define('_MD_MESSAGE_FAVORITES3', 'Echec mise � jour!');
define('_MD_MESSAGE_FAVORITES4', 'Mise � jour');
define('_MD_MESSAGE_FAVORITES5', 'Delete');

define('_MD_MESSAGE_SETTINGS', 'Param�tres de Message Priv�');
define('_MD_MESSAGE_SETTINGS_MSG1', 'Utiliser Message Priv�');
define('_MD_MESSAGE_SETTINGS_MSG2', 'Envoyer par email');
define('_MD_MESSAGE_SETTINGS_MSG3', 'Modifier les param�tres');
define('_MD_MESSAGE_SETTINGS_MSG4', 'Echec mise � jour !');
define('_MD_MESSAGE_SETTINGS_MSG5', 'Vous ne pouvez pas utiliser Message Priv�. Veuillez modifier les param�tres.');
define('_MD_MESSAGE_SETTINGS_MSG6', 'L\'utilisateur s�lectionn� ne peut pas recevoir le message.');
define('_MD_MESSAGE_SETTINGS_MSG7', 'Le message est affich� dans le courrier �lectronique.');
define('_MD_MESSAGE_SETTINGS_MSG8', 'Nombre de messages affich�s par page');
define('_MD_MESSAGE_SETTINGS_MSG9', 'Si la valeur est 0, utilise les param�tres par d�faut.');
define('_MD_MESSAGE_SETTINGS_MSG10', 'Liste Noire');
define('_MD_MESSAGE_SETTINGS_MSG11', 'IDs des utilisateurs s�par�s par une virgule.');
define('_MD_MESSAGE_SETTINGS_MSG12', '{0} ajout� � la Liste Noire.');
define('_MD_MESSAGE_SETTINGS_MSG13', 'Echec en ajoutant {0} � la Liste Noire.');
define('_MD_MESSAGE_SETTINGS_MSG14', '{0} existe d�j�.');
define('_MD_MESSAGE_SETTINGS_MSG15', 'Gestion de la Liste Noire');
define('_MD_MESSAGE_SETTINGS_MSG16', 'L\'utilisateur a �t� supprim�.');
define('_MD_MESSAGE_SETTINGS_MSG17', 'Echec en retirant l\'utilisateur.');
define('_MD_MESSAGE_SETTINGS_MSG18', 'D�tails');
define('_MD_MESSAGE_SETTINGS_MSG19', 'L\'utilisateur n\'existe pas.');

define('_MD_MESSAGE_MAILSUBJECT', 'Vous avez un Nouveau Message');
define('_MD_MESSAGE_MAILBODY', '{0} Connectez-vous, s\'il vous pla�t.');

define('_MD_MESSAGE_ADDBLACKLIST', 'Ajouter cet utilisateur � la Liste Noire.');

define('_MD_MESSAGE_DELETEMSG1', 'Le param�tre est ill�gal.');
define('_MD_MESSAGE_DELETEMSG2', 'Il n\'est pas s�lectionn�.');

define('_MD_MESSAGE_SEARCH', 'Rechercher');

if ( !defined('XCORE_MAIL_LANG') ) {
  define('XCORE_MAIL_LANG','fr');
  define('XCORE_MAIL_CHAR','iso-8859-1');
  define('XCORE_MAIL_ENCO','7bit');
}
?>
