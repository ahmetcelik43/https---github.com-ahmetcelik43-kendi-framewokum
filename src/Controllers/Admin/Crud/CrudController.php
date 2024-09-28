<?php

namespace App\Controllers\Admin\Crud;

use App\Controllers\AdminController;
use App\Entity\Models\Member;

class CrudController extends AdminController
{
    public function index(string $name)
    {
        switch ($name) {
            case 'member':
                $model = new Member();
                $data["data"] = $model->getQuery($model);
                $data["name"] = $name;
                $data["title"] = "Members";
                $data["labels"] = ["member_name" => "Member Name", "member_email" => "Member Email", "status" => "Member Status"];
                $data["labelKeys"] = array_keys($data["labels"]);
                $data["id_column"] = $model->primaryKey;
                //debug($data);
                return view('Admin/Crud/index', $data);
                break;

            default:
                # code...
                break;
        }
    }

    public function get(string $name, int $id = null)
    {
        switch ($name) {
            case 'member':
                if ($id) {
                    $model = new Member();
                    $data["data"] = $model->getSingleQuery($model, $id);
                }
                $data["title"] = "Members";
                $data["name"] = $name;
                $data["labels"] = [
                    "member_name" => ["title" => "Member Name", "type" => "text"],
                    "member_email" => ["title" => "Member Email", "type" => "email"],
                    "member_password" => ["title" => "Member Password", "type" => "password","isverify"=>true]
                ];
                $data["id_column"] = $model->primaryKey;
                $data["labelKeys"] = array_keys($data["labels"]);
                return view('Admin/Crud/get', $data);
                break;

            default:
                # code...
                break;
        }
    }

    public function save(string $name, int $id = null)
    {
        switch ($name) {
            case 'member':
                $model = new Member();
                $model->saveQuery($model, $id, $_POST["data"]);
                header('location:'.baseurl('crud.index',["name"=>"member"]));
                break;

            default:
                # code...
                break;
        }
    }

    public function delete(string $name, int $id)
    {
        switch ($name) {
            case 'member':
                $model = new Member();
                $model->deleteQuery($model, $id);
                header('location:'.baseurl('crud.index',["name"=>"member"]));
                break;

            default:
                # code...
                break;
        }
    }
}
