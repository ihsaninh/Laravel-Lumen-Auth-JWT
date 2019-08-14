<?php

namespace App\Http\Controllers;

use App\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        try {
            $students = Student::orderBy('nama', 'asc')->get();
            return response()->json([
                'message' => 'Success Retrieved Students',
                'students' => $students,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal server error',
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nis' => 'required|size:9',
            'nama' => 'required',
            'email' => 'required|email|unique:students',
            'jurusan' => 'required',
            'gender' => 'required',
        ]);
        try {
            $studentData = $request->only(['nis', 'nama', 'email', 'jurusan', 'gender']);
            $newStudent = Student::create($studentData);
            return response()->json([
                'message' => 'Successed Create New Student',
                'student' => $newStudent,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal server error',
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $student = Student::find($id);
            if ($student) {
                return response()->json([
                    'message' => 'Success Retrieved Student',
                    'student' => $student,
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Student Not Found',
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal server error',
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nis' => 'required|size:9',
            'nama' => 'required',
            'email' => 'required',
            'jurusan' => 'required',
            'gender' => 'required',
        ]);
        try {
            $student = Student::find($id);
            if ($student) {
                $studentData = $request->only(['nis', 'nama', 'email', 'jurusan', 'gender']);
                $studentUpdate = $student->update($studentData);
                return response()->json([
                    'message' => 'Success Updated Data',
                    'student' => $student,
                ], 200);
            } else {
                return response()->json([
                    'message' => 'student Not Found',
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal server error',
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $student = Student::find($id);
            if ($student) {
                $student->delete();
                return response()->json([
                    'message' => 'Success Deleted Student',
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Student Not Found',
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal server error',
            ], 500);
        }
    }
}
