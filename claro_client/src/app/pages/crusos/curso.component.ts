import { HttpClient } from '@angular/common/http';
import { Component } from '@angular/core';
import { AppService } from '@services/app.service';

interface Course {
    id?: number;
    nombre: string;
    horario: string;
    fecha_inicio: string;
    fecha_fin: string;
    tipo: string;
}

interface ApiResponse {
    current_page: number;
    data: Course[];
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
    selector: 'app-blank',
    templateUrl: './curso.component.html',
    styleUrls: ['./curso.component.scss'],
})
export class CursoComponent {
    public currentPageData: Course[] = [];
    totalItems: number = 0;
    links: { url: string | null; label: string; active: boolean; }[] = [];
    showCreateModal = false;
    showEditModal = false;
    showAddStudentModal = false;
    selectedCourse: Course = {
        nombre: '',
        horario: '',
        fecha_inicio: '',
        fecha_fin: '',
        tipo: '',
    };
    studentCedula: string = '';

    constructor(private http: HttpClient, private appService: AppService,) { }

    ngOnInit(): void {
        this.loadData(`${this.appService.apiUrl}/courses?page=1`);
    }

    loadData(url: string): void {
        this.http.get<ApiResponse>(url).subscribe((response) => {
            this.currentPageData = response.data;
            this.totalItems = response.total;
            this.links = response.links;
        });
    }

    createCourse(): void {
        this.http
            .post<Course>(`${this.appService.apiUrl}/courses`, this.selectedCourse)
            .subscribe((course) => {
                this.currentPageData.push(course);
                this.addStudentToCourse(course.id);
                this.closeModal();
                this.loadData(`${this.appService.apiUrl}/courses?page=1`);
            });
    }

    editCourse(course: Course): void {
        this.selectedCourse = {
            ...course,
            fecha_inicio: course.fecha_inicio ? formatDate(new Date(course.fecha_inicio)) : null,
            fecha_fin: course.fecha_fin ? formatDate(new Date(course.fecha_fin)) : null,
        };
        this.showEditModal = true;
    }

    updateCourse(): void {
        if (this.selectedCourse.id) {
            this.http
                .put<Course>(`${this.appService.apiUrl}/courses/${this.selectedCourse.id}`, this.selectedCourse)
                .subscribe((updatedCourse) => {
                    const index = this.currentPageData.findIndex((c) => c.id === updatedCourse.id);
                    this.currentPageData[index] = updatedCourse;
                    this.addStudentToCourse(updatedCourse.id);
                    this.closeModal();
                    this.loadData(`${this.appService.apiUrl}/courses?page=1`);
                });
        }
    }

    deleteCourse(id: number): void {
        this.http.delete(`${this.appService.apiUrl}/courses/${id}`).subscribe(() => {
            this.currentPageData = this.currentPageData.filter((c) => c.id !== id);
        });
    }

    closeModal(): void {
        this.showCreateModal = false;
        this.showEditModal = false;
        this.selectedCourse = { nombre: '', horario: '', fecha_inicio: '', fecha_fin: '', tipo: '' };
        this.studentCedula = '';
    }
    closeAddStudentModal(): void {
        this.showAddStudentModal = false;
        this.studentCedula = '';
    }

    addStudentToCourse(courseId: number): void {
        if (this.studentCedula) {
            this.http
                .post(`${this.appService.apiUrl}/courses/${courseId}/students/${this.studentCedula}`, null)
                .subscribe(
                    () => {
                        console.log('Student added to course successfully');
                        this.closeAddStudentModal();
                    },
                    (error) => {
                        console.error('Error adding student to course:', error);
                    }
                );
        }
    }
}


function formatDate(date: Date): string {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
}