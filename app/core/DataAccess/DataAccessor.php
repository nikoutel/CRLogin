<?php
interface DataAccessor{
    public function create(array $values, $dataSet);
    public function read(array $fields, $dataset, array $conditions);
    public function update(array $values, $dataSet, array $conditions);
    public function delete($dataSet, array $conditions);
    
}
?>
