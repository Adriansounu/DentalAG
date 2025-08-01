<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

// Simulación de base de datos de empleos
// En producción, esto vendría de una base de datos real
$jobs = [
    [
        'id' => 1,
        'title' => 'Odontólogo General',
        'department' => 'clinico',
        'location' => 'Ramos Arizpe, Coahuila',
        'type' => 'Tiempo Completo',
        'experience' => '2+ años',
        'description' => 'Buscamos un odontólogo general con experiencia en tratamientos preventivos y restaurativos. Ambiente familiar y oportunidades de crecimiento.',
        'requirements' => [
            'Título de Odontología',
            'Cédula profesional vigente',
            'Experiencia mínima 2 años',
            'Habilidades de comunicación excelentes',
            'Conocimiento en endodoncia básica',
            'Manejo de software dental'
        ],
        'posted' => '2024-08-01',
        'salary' => '$15,000 - $25,000',
        'benefits' => [
            'Seguro médico',
            'Capacitación continua',
            'Bonos por productividad',
            'Ambiente de trabajo agradable'
        ],
        'active' => true
    ],
    [
        'id' => 2,
        'title' => 'Ortodoncista',
        'department' => 'clinico',
        'location' => 'Ramos Arizpe, Coahuila',
        'type' => 'Medio Tiempo',
        'experience' => '3+ años',
        'description' => 'Especialista en ortodoncia para atender pacientes de todas las edades. Trabajo con brackets metálicos, estéticos y alineadores.',
        'requirements' => [
            'Especialidad en Ortodoncia',
            'Cédula de especialidad',
            'Experiencia mínima 3 años',
            'Conocimiento en alineadores invisibles',
            'Manejo de software de ortodoncia'
        ],
        'posted' => '2024-08-01',
        'salary' => '$20,000 - $35,000',
        'benefits' => [
            'Horario flexible',
            'Comisiones atractivas',
            'Equipo de última tecnología',
            'Capacitación en nuevas técnicas'
        ],
        'active' => true
    ],
    [
        'id' => 3,
        'title' => 'Asistente Dental',
        'department' => 'clinico',
        'location' => 'Ramos Arizpe, Coahuila',
        'type' => 'Tiempo Completo',
        'experience' => '1+ año',
        'description' => 'Únete a nuestro equipo como asistente dental. Buscamos persona responsable, organizada y con vocación de servicio.',
        'requirements' => [
            'Certificación en Asistencia Dental',
            'Experiencia en clínicas dentales',
            'Conocimiento en esterilización',
            'Trabajo en equipo',
            'Disponibilidad de horario',
            'Conocimientos básicos de radiología'
        ],
        'posted' => '2024-08-01',
        'salary' => '$8,000 - $12,000',
        'benefits' => [
            'Capacitación constante',
            'Ambiente familiar',
            'Prestaciones de ley',
            'Oportunidad de crecimiento'
        ],
        'active' => true
    ],
    [
        'id' => 4,
        'title' => 'Recepcionista',
        'department' => 'administrativo',
        'location' => 'Ramos Arizpe, Coahuila',
        'type' => 'Tiempo Completo',
        'experience' => 'Sin experiencia',
        'description' => 'Buscamos recepcionista para atención al cliente, manejo de citas y tareas administrativas básicas.',
        'requirements' => [
            'Preparatoria terminada',
            'Excelente atención al cliente',
            'Manejo básico de computadora',
            'Disponibilidad de horario',
            'Buena presentación',
            'Facilidad de palabra'
        ],
        'posted' => '2024-08-01',
        'salary' => '$7,000 - $10,000',
        'benefits' => [
            'Capacitación inicial',
            'Ambiente agradable',
            'Prestaciones de ley',
            'Horario fijo'
        ],
        'active' => true
    ],
    [
        'id' => 5,
        'title' => 'Auxiliar de Limpieza',
        'department' => 'apoyo',
        'location' => 'Ramos Arizpe, Coahuila',
        'type' => 'Medio Tiempo',
        'experience' => 'Sin experiencia',
        'description' => 'Persona responsable para mantener la limpieza y desinfección de la clínica según protocolos sanitarios.',
        'requirements' => [
            'Secundaria terminada',
            'Responsabilidad y puntualidad',
            'Conocimiento en productos de limpieza',
            'Disponibilidad de horario matutino',
            'Experiencia en limpieza preferible'
        ],
        'posted' => '2024-08-01',
        'salary' => '$4,000 - $6,000',
        'benefits' => [
            'Horario matutino',
            'Ambiente de trabajo seguro',
            'Prestaciones básicas',
            'Estabilidad laboral'
        ],
        'active' => true
    ],
    [
        'id' => 6,
        'title' => 'Coordinador de Citas',
        'department' => 'administrativo',
        'location' => 'Ramos Arizpe, Coahuila',
        'type' => 'Tiempo Completo',
        'experience' => '1+ año',
        'description' => 'Responsable de coordinar citas, seguimiento a pacientes y manejo de agenda de doctores.',
        'requirements' => [
            'Experiencia en atención al cliente',
            'Manejo de software de citas',
            'Excelente organización',
            'Comunicación efectiva',
            'Conocimientos básicos de facturación',
            'Manejo de redes sociales básico'
        ],
        'posted' => '2024-08-01',
        'salary' => '$9,000 - $13,000',
        'benefits' => [
            'Bonos por metas',
            'Capacitación en sistemas',
            'Crecimiento profesional',
            'Ambiente dinámico'
        ],
        'active' => true
    ]
];

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        // Filtrar solo empleos activos
        $activeJobs = array_filter($jobs, function($job) {
            return $job['active'];
        });
        
        // Si hay parámetro de filtro por departamento
        if (isset($_GET['department']) && $_GET['department'] !== 'all') {
            $department = $_GET['department'];
            $activeJobs = array_filter($activeJobs, function($job) use ($department) {
                return $job['department'] === $department;
            });
        }
        
        // Reindexar array
        $activeJobs = array_values($activeJobs);
        
        echo json_encode($activeJobs);
        break;
        
    case 'POST':
        // Manejar nueva postulación
        $input = json_decode(file_get_contents('php://input'), true);
        
        // Aquí se guardaría la postulación en la base de datos
        // Por ahora solo simulamos una respuesta exitosa
        
        $response = [
            'success' => true,
            'message' => 'Postulación recibida exitosamente',
            'application_id' => uniqid(),
            'timestamp' => date('Y-m-d H:i:s')
        ];
        
        echo json_encode($response);
        break;
        
    default:
        http_response_code(405);
        echo json_encode(['error' => 'Método no permitido']);
        break;
}
?>
