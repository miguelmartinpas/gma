INSERT INTO Status (id,name,icon,colour,isDefaultStatus,idNextStatus) values (1,'Sin estado','glyphicon-minus','btn',1,null);
INSERT INTO Status (id,name,icon,colour,isDefaultStatus,idNextStatus) values (2,'Activo','glyphicon-ok','btn-success',0,null);
INSERT INTO Status (id,name,icon,colour,isDefaultStatus,idNextStatus) values (3,'Inactivo','glyphicon-remove','btn-danger',0,null);
INSERT INTO Status (id,name,icon,colour,isDefaultStatus,idNextStatus) values (4,'Reserva','glyphicon-asterisk','btn-warning',0,null);

UPDATE Status SET idNextStatus=2 WHERE id=1;
UPDATE Status SET idNextStatus=3 WHERE id=2;
UPDATE Status SET idNextStatus=4 WHERE id=3;
UPDATE Status SET idNextStatus=1 WHERE id=4;

INSERT INTO User (`id`, `user`, `pass`, `name`, `email`, `isadmin`) VALUES (1,'inmacerezo',MD5('inmacerezo00'),'Inma Cerezo','inmacerezo@hotmail.com',0);
INSERT INTO User (`id`, `user`, `pass`, `name`, `email`, `isadmin`) VALUES (2,'lola',MD5('dmherrera00'),'Lola Martin','dmherrera@malaga.eu',0);
INSERT INTO User (`id`, `user`, `pass`, `name`, `email`, `isadmin`) VALUES (3,'mariajesus',MD5('mjgallegopa00'),'Maria Jesus','mjgallegopa@hotmail.com',0);
INSERT INTO User (`id`, `user`, `pass`, `name`, `email`, `isadmin`) VALUES (4,'sandra',MD5('slarmada00'),'Sandra Armada','slarmada@hotmail.com',0);
INSERT INTO User (`id`, `user`, `pass`, `name`, `email`, `isadmin`) VALUES (5,'marisa ',MD5('mlmerida00'),'Marisa','mlmerida@malaga.eu',0);
INSERT INTO User (`id`, `user`, `pass`, `name`, `email`, `isadmin`) VALUES (6,'joseantonio ',MD5('martosgea00'),'Jose Antonio','martosgea@hotmail.com',0);
INSERT INTO User (`id`, `user`, `pass`, `name`, `email`, `isadmin`) VALUES (7,'joserosado',MD5('joserosadoblanco00'),'Jose Rosado','joserosadoblanco@gmail.com',0);
INSERT INTO User (`id`, `user`, `pass`, `name`, `email`, `isadmin`) VALUES (8,'pacosaldana',MD5('fransalpe00'),'Paco Saldana','fransalpe@hotmail.com',0);
INSERT INTO User (`id`, `user`, `pass`, `name`, `email`, `isadmin`) VALUES (9,'juanantonio',MD5('jrios00'),'Juan Antonio','jrios1986@hotmail.com',0);
INSERT INTO User (`id`, `user`, `pass`, `name`, `email`, `isadmin`) VALUES (10,'rosario',MD5('rvalera00'),'Rosario','rvalera@malaga.eu',0);
INSERT INTO User (`id`, `user`, `pass`, `name`, `email`, `isadmin`) VALUES (11,'paloma',MD5('polveira00'),'Paloma','polveira@malaga.eu',0);
INSERT INTO User (`id`, `user`, `pass`, `name`, `email`, `isadmin`) VALUES (12,'miguelangel',MD5('miguebau00'),'Miguel Angel','miguebau@hotmail.com',0);
INSERT INTO User (`id`, `user`, `pass`, `name`, `email`, `isadmin`) VALUES (13,'mar',MD5('mmmerchan00'),'Mar','mmmerchan@malaga.eu',0);
INSERT INTO User (`id`, `user`, `pass`, `name`, `email`, `isadmin`) VALUES (14,'juan',MD5('jjmendez00'),'Juan Mendez','jjmendez@malaga.eu',1);

INSERT INTO SystemParam (`id`,`key`,`value`) VALUES (1,'adminname','superadmin');
INSERT INTO SystemParam (`id`,`key`,`value`) VALUES (2,'adminpass','5a5bffd1b2ad0285463636f8527cfd15');
INSERT INTO SystemParam (`id`,`key`,`value`) VALUES (3,'adminid','999999999');
INSERT INTO SystemParam (`id`,`key`,`value`) VALUES (4,'path','/web');
