/*Insercion de usuarios*/
insert into usuarios(nickname, usuarios_nombre, ultingreso, categorias_nombre)
values ('stephanie', 'STEPHANIE ABAD', '2019-03-26', 'udem');

insert into usuarios(nickname, usuarios_nombre, ultingreso, categorias_nombre)
values ('juand', 'JUAN DAVID ABAD DIAZ', '2019-03-26T9:21:59.001+0000', 'derecho');

insert into usuarios(nickname, usuarios_nombre, ultingreso, categorias_nombre)
values ('piedad', 'PIEDAD ABAD ALVAREZ', '2019-03-20T15:00:59.001+0000', 'telecomunicaciones');

insert into usuarios(nickname, usuarios_nombre, ultingreso, categorias_nombre)
values ('melisa', 'MELISA ABAD CARRASCO', '2019-03-25T11:20:59.001+0000', 'finanzas');

insert into usuarios(nickname, usuarios_nombre, ultingreso, categorias_nombre)
values ('manuela', 'MANUELA ABAD DUQUE', '2019-03-23T12:21:59.001+0000', 'sistemas');

insert into usuarios(nickname, usuarios_nombre, ultingreso,categorias_nombre)
values ('juanf', 'JUAN FERNANDO ABAD ECHEVERRI', '2019-03-26T11:21:59.001+0000', 'ingenierias');

insert into usuarios(nickname, usuarios_nombre, ultingreso,categorias_nombre)
values ('rodri', 'RODRIGO LOPEZ GARCIA', '2019-03-28T11:21:59.001+0000', 'ingenierias');

insert into usuarios2(nickname, usuarios_nombre, ultingreso,categorias_nombre)
values ('rodri', 'RODRIGO LOPEZ GARCIA', '2019-03-28', 'ingenierias');

/*Insercion de categorias*/
insert into categorias(dummy, categorias_nombre)
values(1, 'udem');

insert into categorias(dummy, categorias_nombre)
values(1, 'ingenierias');

insert into categorias(dummy, categorias_nombre)
values(1, 'sistemas');

insert into categorias(dummy, categorias_nombre)
values(1, 'telecomunicaciones');

insert into categorias(dummy, categorias_nombre)
values(1, 'derecho');

insert into categorias(dummy, categorias_nombre)
values(1, 'finanzas');

/*Insercion de eventos*/
/* En vez de usar insert, se usa update para actualizar NOTA: tener encuenta en el where las claves de closterizacion*/
/*Para crear un nuevo evento o para maracar una asistencia se usa esta linea*/
update eventos set nasistentes = nasistentes + 0 where dummy = 2 and eventos_id = 1 and feevento = '2019-03-30T20:10:00.001+0000' and dsevento = 'Gamer';
update eventos set nasistentes = nasistentes + 0 where dummy = 2 and eventos_id = 2 and feevento = '2019-03-29T20:10:00.001+0000' and dsevento = 'Otakus';
update eventos set nasistentes = nasistentes + 0 where dummy = 2 and eventos_id = 3 and feevento = '2019-03-28T20:10:00.001+0000' and dsevento = 'TI';
update eventos set nasistentes = nasistentes + 0 where dummy = 2 and eventos_id = 4 and feevento = '2019-03-27T20:10:00.001+0000' and dsevento = 'IoT';
update eventos set nasistentes = nasistentes + 0 where dummy = 2 and eventos_id = 5 and feevento = '2019-03-26T20:10:00.001+0000' and dsevento = 'IA';
update eventos set nasistentes = nasistentes + 0 where dummy = 2 and eventos_id = 6 and feevento = '2019-03-26T20:10:00.001+0000' and dsevento = 'Foro Cassandra';

/*Insercion de publicaciones*/
update publicaciones set likes = likes + 0 where publicaciones_id = 1 and categorias_nombre = 'derecho' and dspubli = 'Excelente el foro';
update publicaciones set likes = likes + 0 where publicaciones_id = 2 and categorias_nombre = 'sistemas' and dspubli = 'Recuerden lenar la encuesta de reacreditacion';

/*Insercion de catSecun*/
insert into catSecun (nickname, catsecun_id, categorias_nombre) values ('stephanie', 1, 'ingenierias');
insert into catSecun (nickname, catsecun_id, categorias_nombre) values ('stephanie', 2, 'sistemas');
insert into catSecun (nickname, catsecun_id, categorias_nombre) values ('juand', 3, 'udem');
insert into catSecun (nickname, catsecun_id, categorias_nombre) values ('juand', 4, 'telecomunicaciones');

/*Insercion de agendas/asistencias*/
insert into agendas (agendas_id, nickname, eventos_id, dsevento) values (1, 'stephanie', 5, 'IA');
insert into agendas (agendas_id, nickname, eventos_id, dsevento) values (2, 'stephanie', 4, 'IoT');
insert into agendas (agendas_id, nickname, eventos_id, dsevento) values (3, 'piedad', 2, 'Otakus');
insert into agendas (agendas_id, nickname, eventos_id, dsevento) values (4, 'piedad', 1, 'Gamer');
insert into agendas (agendas_id, nickname, eventos_id, dsevento) values (5, 'stephanie', 4, 'IoT');