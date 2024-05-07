<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RSAKey extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rsaKeys';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'hash',
        'content',
        'user_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'content',
    ];

    /**
     * Returns the user it belongs to.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Encapsulates the key in header and footer to comform to PEM format.
     *
     * @return string
     */
    public function pem_format()
    {
        // TODO
    }

    /**
     * sdfds
     *
     * @param string $data The string of data used to generate the signature previously.
     * @param string $signature A raw binary string.
     * @param string $public_key A PEM formatted key.
     * @param int $algorithm Signature algorithm used.
     * @return bool
     */
    public function verify(string $data, string $signature, string $public_key)
    {
        // return openssl_verify($data, $signature, $public_key, OPENSSL_ALGO_SHA256);

        // $validated = $request->validate([
        //     'key' => ['required'],
        //     'sig' => ['required']
        // ]);

        // $binary = '';
        // foreach (explode(',', $validated['sig']) as $char)
        // {
        //     $binary .= chr((int)$char);
        // }

        // $result = openssl_verify(auth()->user()->id, $binary, $validated['key'], OPENSSL_ALGO_SHA256);

        // if ($result == -1)
        // {
        //     return response(json_encode([
        //         'error' => 'Error while verifying signature.',
        //     ], 400));
        // }

        // if ($result == 0)
        // {
        //     return response(json_encode([
        //         'error' => 'Signature verification failed.',
        //     ], 400));
        // }

        // return response(json_encode(['msg' => 'all good']));
    }
}
