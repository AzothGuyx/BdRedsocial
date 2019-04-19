/*Insercion de usuarios mysql*/

INSERT INTO usuario(`id`,`nombre`,`login`,`ultimo_ingreso`) VALUES (1,'STEPHANIE ABAD','stephanie','2019-03-26 11:21:59');
INSERT INTO usuario(`id`,`nombre`,`login`,`ultimo_ingreso`) VALUES (2,'JUAN DAVID ABAD DIAZ', 'juand', '2019-03-26 9:21:59');
INSERT INTO usuario(`id`,`nombre`,`login`,`ultimo_ingreso`) VALUES (3,'PIEDAD ABAD ALVAREZ', 'piedad', '2019-03-20 15:00:59');
INSERT INTO usuario(`id`,`nombre`,`login`,`ultimo_ingreso`) VALUES (4,'MELISA ABAD CARRASCO', 'melisa', '2019-03-25 11:20:59');
INSERT INTO usuario(`id`,`nombre`,`login`,`ultimo_ingreso`) VALUES (5,'MANUELA ABAD DUQUE', 'manuela', '2019-03-23 12:21:59');
INSERT INTO usuario(`id`,`nombre`,`login`,`ultimo_ingreso`) VALUES (6,'JUAN FERNANDO ABAD ECHEVERRI', 'juanf', '2019-03-26 11:21:59');

/*Insercion de categorias mysql*/

INSERT INTO categoria(`nombre`,`principal`,`usuario_id`) VALUES ('Facultad de ciencias basicoas',1,5);
INSERT INTO categoria(`nombre`,`principal`,`usuario_id`) VALUES ('Facultad de ingenierias',1,4);
INSERT INTO categoria(`nombre`,`principal`,`usuario_id`) VALUES ('Facultad de comunicaciones',1,6);
INSERT INTO categoria(`nombre`,`principal`,`usuario_id`) VALUES ('Facultad de ciencias economicas y administrativas',1,3);
INSERT INTO categoria(`nombre`,`principal`,`usuario_id`) VALUES ('Facultad de derecho',1,2);
INSERT INTO categoria(`nombre`,`principal`,`usuario_id`) VALUES ('Facultad de ciencias sociales y humanas',1,1);

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
INSERT INTO evento(`dsevento`,`feevento`) VALUES ('Foro Cassandra','2019-03-26 20:10:00');

/*Insercion de publicaciones mysql*/

INSERT INTO publicacion(`dspublicacion`,`usuario_id`,`categoria_id`) VALUES ('Reseña foro de software 2019-1: Fue un excelente evento con grandes invitados',2,5);	
INSERT INTO publicacion(`dspublicacion`,`usuario_id`,`categoria_id`) VALUES ('Recordatorio: Recuerden llenar la encuesta de re acreditación',3,4);	

/*Insercion de likes mysql*/

INSERT INTO likes(`numLikes`,`publicacion_id`) VALUES (0,1);
INSERT INTO likes(`numLikes`,`publicacion_id`) VALUES (0,2);

/*Insercion de agendas mysql*/

INSERT INTO agenda (`evento_id`,`usuario_id`) VALUES (5,1);
INSERT INTO agenda (`evento_id`,`usuario_id`) VALUES (4,1);
INSERT INTO agenda (`evento_id`,`usuario_id`) VALUES (2,3);
INSERT INTO agenda (`evento_id`,`usuario_id`) VALUES (1,3);
INSERT INTO agenda (`evento_id`,`usuario_id`) VALUES (4,1); 
