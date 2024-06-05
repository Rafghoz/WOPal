namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PackagesRequest extends FormRequest
{
    public function authorize()
    {
        // Ubah ini jika Anda ingin mengatur otorisasi khusus.
        return true;
    }

    public function rules()
    {
        return [
            'package_name' => 'required',
            'package_price' => 'required|numeric',
            'description' => 'required',
            'id_wo' => 'required',
        ];
        if ($this->is('api/v1/packages/update/*')) {
            $rules['package_name'] = 'required';
            $rules['package_price'] = 'required|numeric';
            $rules['package_image'] = 'mimes:png,jpg,jpeg';
            $rules['description'] = 'required';
            $rules['id_wo'] = 'required';
        } else {
            $rules['package_name'] = 'required';
            $rules['package_price'] = 'required|numeric';
            $rules['address'] = 'required';
            $rules['package_image'] = 'required|mimes:png,jpg,jpeg';
            $rules['description'] = 'required';
            $rules['id_wo'] = 'required';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'package_name.required' => 'Package name is required',
            'package_price.required' => 'Package price is required',
            'description.required' => 'Description is required',
            'id_wo.required' => 'Tailor ID is required',
            'id_wo.exists' => 'Tailor ID must exist in the tailors table',
            'package_image.image' => 'Package image must be an image file',
            'package_image.mimes' => 'Package image must be a file of type: jpeg, png, jpg, gif',
            'package_image.max' => 'Package image must not be larger than 2MB',
        ];
    }
}
