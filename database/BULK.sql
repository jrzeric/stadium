USE [seatOrganizer];
GO
BULK INSERT [catalogo].[areas_ctg]
FROM 'C:\xampp\htdocs\stadium\database\areas_ctg.csv' WITH (
	FIELDTERMINATOR= ',',
	ROWTERMINATOR = '\n'
);
go