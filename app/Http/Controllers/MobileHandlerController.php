<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MobileHandlerController extends Controller
{
    //
    public function uploadImage(Request $request)
    {
        try {
            // Validate the incoming request
            $request->validate([
                'ktp_img' => 'required|image|mimes:jpeg,png,jpg,gif|max:10000',
            ]);

            // Get the uploaded image file
            $image = $request->file('ktp_img');

            // You can customize the file name and storage location as needed
            $fileName = 'ktp_img_' . time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('images/ktp', $fileName, 'public');

            // You can save the image path to a database or perform additional processing

            // Return a response indicating success or the saved image path
            return response()->json(['message' => 'Image uploaded successfully', 'path' => $path]);
        } catch (\Exception $e) {
            // Handle exceptions (e.g., validation errors, file upload issues)
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function receiveKtpImage2(Request $request)
    {
        // Output the request data for debugging purposes
        return response()->json([
            'data' => $request->ktp_img,
        ], 200);

        // The code below will not be executed due to the previous return statement

        if (!request()->hasFile('ktp_img')) {
            return response()->json([
                'error' => 'no file'
            ], 200);
        }

        $filepath = request()->file('ktp_img')->store('images/ktp', 'public');
        $filename = pathinfo($filepath, PATHINFO_FILENAME);
        return $filename;

        // $file->storeAs('images/ktp', request()->image_name,['disk' => 'public']);

        // return response()->json([
        //     'message' => 'success'
        // ],200);
    }
}
