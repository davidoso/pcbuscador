-- Declare the variable to be used
DECLARE @filepath varchar(100);
DECLARE @url varchar(100);
-- Initialize the variable
SET @filepath = 'C:\masterweb\webdocs\X106\201708231635331883.pdf';
SET @url =  CONCAT('http://vwebdelta:8088/', REPLACE(RIGHT(@filepath, LEN(@filepath) - 13),'\','/'));
SELECT @url AS url
IF(@url = 'http://vwebdelta:8088/webdocs/X106/201708231635331883.pdf')
	SELECT 'Strings are the same'
ELSE
	SELECT 'They are not the same'

SELECT CONCAT('http://vwebdelta:8088/', REPLACE(RIGHT(archivo, LEN(archivo) - 13),'\','/'))


--Referencias:
--http://www.latindevelopers.com/articulo/if-iif-en-sql-server/
--https://stackoverflow.com/questions/35485607/return-zero-if-value-less-than-zero
--https://social.msdn.microsoft.com/Forums/es-ES/c5824519-bb6c-40a3-9f25-31cd61ce4e87/hacer-select-sin-tener-en-cuenta-acentos-mayusculas-o-minusculas?forum=sqlserveres


--BUSCAMW WEB SERVICE

SELECT
	a.INFO_CARD_ID,
	a.document_num as CLAVE,
	IIF(a.revision_nm = 0, '-', CAST(a.revision_nm as varchar(3))) as REVISION,
	a.access_category_id as BOVEDA,
	a.title_nm as DOCUMENTO,
	a.document_type as TIPO_DOC,
	(CASE WHEN (SUBSTRING(a.card_properties,1,1))<>0 THEN 'pdf' ELSE +(RIGHT(a.file_nam, CHARINDEX('.', REVERSE(a.file_nam)) - 1)) END) as EXT,
	'http://vwebdelta:8088/webdocs/' + a.published_dir + '/' + a.info_card_id + (CASE WHEN (SUBSTRING(a.card_properties,1,1))<>0 THEN '.pdf' ELSE + '.' + (RIGHT(a.file_nam, CHARINDEX('.', REVERSE(a.file_nam)) - 1)) END) as ARCHIVO
FROM m_doc_infocard a
WHERE a.access_category_id IN( SELECT access_category_id FROM m_sys_categories WHERE vault_properties LIKE '012%' )
	AND (title_nm LIKE '%VALOR%' OR file_nam LIKE '% VALOR %')
	AND a.access_category_id IN( SELECT DISTINCT access_category_id FROM [masterweb].[dbo].[m_sys_group_user] a
		INNER JOIN [masterweb].[dbo].[m_sys_group_categories] b ON a.group_id = b.group_id WHERE a.user_id = 'GQUITENO' )
	AND published_dir IS NOT NULL
COLLATE Traditional_Spanish_ci_ai