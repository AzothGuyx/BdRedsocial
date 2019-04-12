CREATE KEYSPACE RedSocial WITH replication = {'class':'SimpleStrategy', 'replication_factor':1};
USE RedSocial;

CREATE TABLE usuarios (nickname TEXT, usuarios_nombre TEXT, ultingreso TIMESTAMP, categorias_nombre TEXT, PRIMARY KEY (nickname));

CREATE TABLE eventos (dummy INT, feevento TIMESTAMP, eventos_id INT, dsevento TEXT, nasistentes COUNTER, PRIMARY KEY (dummy,feevento,eventos_id,dsevento)) WITH CLUSTERING ORDER BY (feevento ASC, eventos_id ASC, dsevento ASC);

CREATE TABLE publicaciones (categorias_nombre TEXT, publicaciones_id INT, dspubli TEXT, likes COUNTER, PRIMARY KEY (categorias_nombre,publicaciones_id,dspubli)) WITH CLUSTERING ORDER BY (publicaciones_id ASC, dspubli ASC);

CREATE TABLE categorias (dummy INT, categorias_nombre TEXT, PRIMARY KEY (dummy,categorias_nombre)) WITH CLUSTERING ORDER BY (categorias_nombre ASC);

CREATE TABLE catSecun (nickname TEXT, catsecun_id INT, categorias_nombre TEXT, PRIMARY KEY (nickname,catsecun_id)) WITH CLUSTERING ORDER BY (catsecun_id ASC);

CREATE TABLE agendas (agendas_id INT, nickname TEXT, eventos_id INT, dsevento TEXT, PRIMARY KEY (nickname,agendas_id)) WITH CLUSTERING ORDER BY (agendas_id ASC);



