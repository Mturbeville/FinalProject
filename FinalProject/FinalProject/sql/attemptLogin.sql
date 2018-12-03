/* Select customers where the username and password match those passed as parameters */
SELECT *
FROM admin
WHERE
	login = :username AND
	password = :password
	