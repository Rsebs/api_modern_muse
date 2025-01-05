<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Submodules\PhpHelpers\Traits\ApiResponse;

class ProductRequest extends FormRequest
{
  use ApiResponse;

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
      'name' => 'required|unique:products,name,' . $this->route('product')?->id . ',id',
      'price' => 'required|numeric|min:1'
    ];
  }

  public function failedValidation(Validator $validator)
  {
    throw new HttpResponseException(
      $this->errorResponse($validator->errors()->messages()),
    );
  }
}
