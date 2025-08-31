<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
                'name' => ['required', 'string', 'max:190'],
                'description' => ['required', 'string'],
                'price' => ['required', 'numeric'],
                'category' => ['required', 'string'],
                'stock' => ['required', 'integer'],
                'image' => ['nullable','mimes:jpeg,jpg,png'],
        ];
    }

    public function persist(){
        return [
                'name' => $this->name,
                'description' => $this->description,
                'price' => $this->price,
                'category' => $this->category,
                'stock' => $this->stock,
                'image' => $this->uploadImage(),
        ];
    }

    public function uploadImage(){
   
        $oldImage = $this->old_image ?? null;
        if($this->hasFile('image')){
            if(isset($oldImage) && file_exists('uploads/product/'.$oldImage)){
                unlink('uploads/product/'.$oldImage);
            }
            $file = $this->file('image');
            $filename = "IMG_".time().'.'. $file->getClientOriginalExtension();
            $file->move(public_path('uploads/product'),$filename);
            return $filename;
        }else{
            return  $oldImage;
        }
    }
}
