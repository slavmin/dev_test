<?php

namespace App;

class PageTemplateBuilder
{
    public static function makePageWrap(string $title = '', string $content = ''): string
    {
        return '<!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>' . $title . '</title>
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
                </head>
                <body><div class="container">' . $content . '</div></body>
                <script>                    
                    function createTableFromJson(data) {
                          let tableHTML = "<table class=\"table table-striped\"><tr>";
                         
                          Object.keys(data[0]).forEach(key => {
                             tableHTML += `<th>${key}</th>`;
                          });
                         
                          tableHTML += "</tr>";
                         
                          data.forEach(item => {
                             tableHTML += "<tr>";
                             Object.values(item).forEach(value => {
                                tableHTML += `<td>${value}</td>`;
                             });
                             tableHTML += "</tr>";
                          });
                         
                          tableHTML += "</table>";
                                    
                          return tableHTML;
                    }
                      
                    let hostname = location.hostname;
                    let pathname = location.pathname;
                    let url = `${hostname}/api`;
                    
                    if (`${hostname}/` !== `${hostname}${pathname}`) {
                        fetch(url)
                          .then((response) => {
                              return response.json();
                            })
                          .then((data) => {
                              console.log(data)
                              const div = document.querySelector("div.container")
                              div.insertAdjacentHTML("beforeend", createTableFromJson(data))
                          });
                    }
                </script>
                </html>';
    }

    public static function makeTable(array $values, array $columnNames = []): string
    {
        $columns = '<tr>';

        if (empty($columnNames)) {
            foreach (array_keys($values[array_key_first($values)]) as $column) {
                $columns .= '<th>' . ucfirst($column) . '</th>';
            }
        } else {
            foreach ($columnNames as $column) {
                $columns .= '<th>' . ucfirst($column) . '</th>';
            }
        }
        $columns .= '</tr>';

        foreach ($values as $row) {
            $columns .= '<tr>';
            foreach ($row as $value) {
                $columns .= '<td>' . $value . '</td>';
            }
            $columns .= '</tr>';
        }

        return '<table class="table table-striped">' . $columns . '</table><nav class="nav nav-pills nav-fill"><a class="nav-link" href="/form">Форма</a></nav>';
    }

    public static function makeForm(): string
    {
        return '<form method="POST" enctype="application/x-www-form-urlencoded">
                  <div class="mb-3">
                    <label for="name_1" class="form-label">Наименование товара *</label>
                    <input name="title[]" type="text" class="form-control" id="name_1">
                  </div>
                  <div class="mb-3">
                    <label for="price_1" class="form-label">Цена товара *</label>
                    <input name="price[]" type="text" class="form-control" id="price_1">
                  </div>
                  <div class="mb-3">
                    <label for="name_2" class="form-label">Наименование товара</label>
                    <input name="title[]" type="text" class="form-control" id="name_2">
                  </div>
                  <div class="mb-3">
                    <label for="price_2" class="form-label">Цена товара</label>
                    <input name="price[]" type="text" class="form-control" id="price_2">
                  </div>
                  <div class="mb-3">
                    <label for="name_3" class="form-label">Наименование товара</label>
                    <input name="title[]" type="text" class="form-control" id="name_3">
                  </div>
                  <div class="mb-3">
                    <label for="price_3" class="form-label">Цена товара</label>
                    <input name="price[]" type="text" class="form-control" id="price_3">
                  </div>
                  <button type="submit" class="btn btn-primary">Отправить</button>
                </form>
                <nav class="nav nav-pills nav-fill"><a class="nav-link" href="/">Список</a></nav>';
    }
}