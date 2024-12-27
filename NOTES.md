### Model::where()
- Using where with Multiple Conditions (AND)
If you want to pass an array to where, it will treat it as an array of column-value pairs and apply them as multiple AND conditions.

- Example:
    ```php
    $users = User::where([
        ['status', '=', 'active'],
        ['age', '>=', 18],
        ['city', '=', 'New York']
    ])->get();
    ```
    In this example, the query will be equivalent to:
    ```sql
    SELECT * FROM users WHERE status = 'active' AND age >= 18 AND city = 'New York';
    ```
- **Note**: Search for additional model methods