﻿/*Insercion de usuarios mysql*/

INSERT INTO usuario(`id`,`nombre`,`login`,`ultimo_ingreso`) VALUES (1,'STEPHANIE ABAD','stephanie','2019-03-26 11:21:59');
INSERT INTO usuario(`id`,`nombre`,`login`,`ultimo_ingreso`) VALUES (2,'JUAN DAVID ABAD DIAZ', 'juand', '2019-03-26 9:21:59');
INSERT INTO usuario(`id`,`nombre`,`login`,`ultimo_ingreso`) VALUES (3,'PIEDAD ABAD ALVAREZ', 'piedad', '2019-03-20 15:00:59');
INSERT INTO usuario(`id`,`nombre`,`login`,`ultimo_ingreso`) VALUES (4,'MELISA ABAD CARRASCO', 'melisa', '2019-03-25 11:20:59');
INSERT INTO usuario(`id`,`nombre`,`login`,`ultimo_ingreso`) VALUES (5,'MANUELA ABAD DUQUE', 'manuela', '2019-03-23 12:21:59');
INSERT INTO usuario(`id`,`nombre`,`login`,`ultimo_ingreso`) VALUES (6,'JUAN FERNANDO ABAD ECHEVERRI', 'juanf', '2019-03-26 11:21:59');

/*Insercion de categorias mysql*/

INSERT INTO categoria(`nombre`,`principal`,`usuario_id`) VALUES ('udem',1,5);
INSERT INTO categoria(`nombre`,`principal`,`usuario_id`) VALUES ('ingenierias',1,4);
INSERT INTO categoria(`nombre`,`principal`,`usuario_id`) VALUES ('sistemas',1,6);
INSERT INTO categoria(`nombre`,`principal`,`usuario_id`) VALUES ('telecomunicaciones',1,3);
INSERT INTO categoria(`nombre`,`principal`,`usuario_id`) VALUES ('derecho',1,2);
INSERT INTO categoria(`nombre`,`principal`,`usuario_id`) VALUES ('finanzas',1,1);
INSERT INTO categoria(`nombre`,`principal`,`usuario_id`) VALUES ('Computación Científica',NULL,5);
INSERT INTO categoria(`nombre`,`principal`,`usuario_id`) VALUES ('Ingenieria de sistemas',NULL,4);
INSERT INTO categoria(`nombre`,`principal`,`usuario_id`) VALUES ('Comuncacion audiovisual',NULL,6);
INSERT INTO categoria(`nombre`,`principal`,`usuario_id`) VALUES ('Negocios internacionales',NULL,3);
INSERT INTO categoria(`nombre`,`principal`,`usuario_id`) VALUES ('Psicología',NULL,2);
INSERT INTO categoria(`nombre`,`principal`,`usuario_id`) VALUES ('Ciencias politicas',NULL,1);

/*Insercion de eventos mysql*/

INSERT INTO evento(`dsevento`,`feevento`) VALUES ('Gamer','2019-03-30 20:10:00');
INSERT INTO evento(`dsevento`,`feevento`) VALUES ('Otakus','2019-03-29 20:10:00');
INSERT INTO evento(`dsevento`,`feevento`) VALUES ('TI','2019-03-28 20:10:00');
INSERT INTO evento(`dsevento`,`feevento`) VALUES ('IoT','2019-03-27 20:10:00');
INSERT INTO evento(`dsevento`,`feevento`) VALUES ('IA','2019-03-26 20:10:00');
INSERT INTO evento(`dsevento`,`feevento`) VALUES ('Foro Cassandra','2019-03-26 10:13:00');
INSERT INTO evento(`dsevento`,`feevento`) VALUES ('Concierto Doctor krapula','2019-04-01 04:00:00');
INSERT INTO evento(`dsevento`,`feevento`) VALUES ('Comicon','2019-05-04 12:40:00');
INSERT INTO evento(`dsevento`,`feevento`) VALUES ('Foro data base','2019-06-16 16:20:00');
INSERT INTO evento(`dsevento`,`feevento`) VALUES ('evento Chido','2019-07-02 11:30:00');
INSERT INTO evento(`dsevento`,`feevento`) VALUES ('otro evento mas','2019-08-06 06:50:00');

/*Insercion de publicaciones mysql*/

INSERT INTO publicacion(`dspublicacion`,`usuario_id`,`categoria_nombre`) VALUES ('Gra concierto de DK',5,"udem");	
INSERT INTO publicacion(`dspublicacion`,`usuario_id`,`categoria_nombre`) VALUES ('Gran evento de Ti',4,"ingenierias");	
INSERT INTO publicacion(`dspublicacion`,`usuario_id`,`categoria_nombre`) VALUES ('publicacion chido',6,"sistemas");	
INSERT INTO publicacion(`dspublicacion`,`usuario_id`,`categoria_nombre`) VALUES ('MySQL es mejor que las otras duelale al que le duela',3,"telecomunicaciones");	
INSERT INTO publicacion(`dspublicacion`,`usuario_id`,`categoria_nombre`) VALUES ('el foro de casandra fue bueno',2,"derecho");	
INSERT INTO publicacion(`dspublicacion`,`usuario_id`,`categoria_nombre`) VALUES ('me gusto mucho la comicon',1,"finanzas");	

/*Insercion de likes mysql*/

INSERT INTO likes(`numLikes`,`publicacion_id`) VALUES (10,1);
INSERT INTO likes(`numLikes`,`publicacion_id`) VALUES (23,2);
INSERT INTO likes(`numLikes`,`publicacion_id`) VALUES (6666666,3);
INSERT INTO likes(`numLikes`,`publicacion_id`) VALUES (0,4);
INSERT INTO likes(`numLikes`,`publicacion_id`) VALUES (53311,5);
INSERT INTO likes(`numLikes`,`publicacion_id`) VALUES (2,6);


/*Insercion de agendas mysql*/

INSERT INTO agenda (`evento_id`,`usuario_id`) VALUES (5,1);
INSERT INTO agenda (`evento_id`,`usuario_id`) VALUES (4,1);
INSERT INTO agenda (`evento_id`,`usuario_id`) VALUES (2,3);
INSERT INTO agenda (`evento_id`,`usuario_id`) VALUES (1,3);
INSERT INTO agenda (`evento_id`,`usuario_id`) VALUES (4,1); 
