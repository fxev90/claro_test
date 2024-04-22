import { HttpClient } from '@angular/common/http';
import { Component } from '@angular/core';

interface Student {
    id?: number;
    nombre: string;
    apellido: string;
    edad: number;
    cedula: string;
    email: string;
    deleted_at: string | null;
    created_at: string;
    updated_at: string;
    courses: Course[];
}

interface Course {
    id: number;
    nombre: string;
    horario: string;
    fecha_inicio: string;
    fecha_fin: string;
    tipo: string;
    deleted_at: string | null;
    created_at: string;
    updated_at: string;
    pivot: {
        student_id: number;
        course_id: number;
    };
}

interface ApiResponse {
    current_page: number;
    data: Student[];
    first_page_url: string;
    from: number | null;
    last_page: number;
    last_page_url: string;
    links: { url: string | null; label: string; active: boolean; }[];
    next_page_url: string | null;
    path: string;
    per_page: number;
    prev_page_url: string | null;
    to: number | null;
    total: number;
}

@Component({
    selector: 'app-students',
    templateUrl: './student.component.html',
    styleUrls: ['./student.component.scss'],
})
export class StudentsComponent {
    public currentPageData: Student[] = [];
    totalItems: number = 0;
    links: { url: string | null; label: string; active: boolean; }[] = [];
    showCreateModal = false;
    showEditModal = false;
    selectedStudent: Student = {
        nombre: '',
        apellido: '',
        edad: 0,
        cedula: '',
        email: '',
        deleted_at: null,
        created_at: '',
        updated_at: '',
        courses: [],
    };

    constructor(private http: HttpClient) { }

    ngOnInit(): void {
        this.loadData('http://claro_api.test/api/students?page=1');
    }

    loadData(url: string): void {
        this.http.get<ApiResponse>(url).subscribe((response) => {
            this.currentPageData = response.data;
            this.totalItems = response.total;
            this.links = response.links;
        });
    }

    createStudent(): void {
        this.http.post<Student>('http://claro_api.test/api/students', this.selectedStudent)
            .subscribe((student) => {
                this.currentPageData.push(student);
                this.closeModal();
                this.loadData('http://claro_api.test/api/students?page=1');
            });
    }

    editStudent(student: Student): void {
        this.selectedStudent = { ...student };
        this.showEditModal = true;
    }

    updateStudent(): void {
        if (this.selectedStudent.id) {
            this.http.put<Student>(`http://claro_api.test/api/students/${this.selectedStudent.id}`, this.selectedStudent)
                .subscribe((updatedStudent) => {
                    const index = this.currentPageData.findIndex((s) => s.id === updatedStudent.id);
                    this.currentPageData[index] = updatedStudent;
                    this.closeModal();
                    this.loadData('http://claro_api.test/api/students?page=1');
                });
        }
    }

    deleteStudent(id: number): void {
        this.http.delete(`http://claro_api.test/api/students/${id}`)
            .subscribe(() => {
                this.currentPageData = this.currentPageData.filter((s) => s.id !== id);
            });
    }

    closeModal(): void {
        this.showCreateModal = false;
        this.showEditModal = false;
        this.selectedStudent = {
            nombre: '',
            apellido: '',
            edad: 0,
            cedula: '',
            email: '',
            deleted_at: null,
            created_at: '',
            updated_at: '',
            courses: [],
        };
    }
}