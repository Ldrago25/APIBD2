---//DESPOSITO,Retiro y Transferencias
DELIMITER $$
CREATE TRIGGER after_insert_transaction
AFTER INSERT ON transactions
FOR EACH ROW
BEGIN
  IF NEW.transactionType = 1 THEN
    UPDATE account_banks
    SET balance = balance + NEW.amount
    WHERE id = NEW.to;
  ELSEIF NEW.transactionType = 2 THEN
    UPDATE account_banks
    SET balance = balance - NEW.amount
    WHERE id = NEW.to;
  ELSEIF NEW.transactionType = 3 THEN
    UPDATE account_banks
    SET balance = balance - NEW.amount
    WHERE id = NEW.from;
    UPDATE account_banks
    SET balance = balance + NEW.amount
    WHERE id = NEW.to;
  END IF;
END;