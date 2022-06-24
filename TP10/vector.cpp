#include <math.h>
#include <mpi.h>
#include <stdio.h>
#include <stdlib.h>
#include <time.h>

int main(int argc, char *argv[]);
void timestamp();

int main(int argc, char *argv[])
{

    int ierr;
    int processId;
    int num_procs;
    double *x;

    int i;
    int processMaster = 0;
    double *processVector;

    double *vectorOfDoubles;
    double escalar;
    int length;
    int tag_done;

    int dest;
    int tag;
    int num_rows;

    int desplazamiento;
    int num_workers;
    double ans;
    MPI_Status status;

    int cantidad;
    int subtotal;
    int diferencia;

    ierr = MPI_Init(&argc, &argv);

    if (ierr != 0)
    {
        printf("\n");
        printf("MATVEC_MPI - Fatal error!\n");
        printf("  MPI_Init returns nonzero IERR.\n");
        exit(1);
    }

    /*
  Get this processor's ID.
*/
    ierr = MPI_Comm_rank(MPI_COMM_WORLD, &processId);
    /*
      Get the number of processors.
    */
    ierr = MPI_Comm_size(MPI_COMM_WORLD, &num_procs);

    if (processId == processMaster)
    {
        timestamp();
        printf("\n");
        printf("MATVEC - Master process:\n");
        printf("  Multiplicacion de un vector por un escalar.\n");
        printf("\n");
        printf("  Compiled on %s at %s.\n", __DATE__, __TIME__);
        printf("\n");
        printf("  The number of processes is %d.\n", num_procs);
    }
    printf("\n");
    printf("Process %d is active.\n", processId);

    length = 11;
    tag_done = length + 1;
    cantidad = trunc(length / (num_procs - 1));
    subtotal = cantidad * (num_procs - 1);
    diferencia = length - subtotal;
    escalar = 10;

    if (processId == processMaster)
    {
        printf("\n");
        printf("  El largo del vector es %d.\n", length);
    }

    if (processId == 0)
    {
        vectorOfDoubles = (double *)malloc(length * sizeof(double));

        for (i = 0; i < length; i++)
        {
            vectorOfDoubles[i] = sqrt(2.0 / (double)(length + 1)) * sin((double)(i));
        }

        printf("\n");
        printf("MATVEC - Master process:\n");
        printf("  Vector x:\n");
        printf("\n");
        for (i = 0; i < length; i++)
        {
            printf("%d %f\n", i, vectorOfDoubles[i]);
        }

        printf("\n");
        printf("MATVEC - Master process:\n");
        printf("  Escalar: %f\n", escalar);
        printf("\n");
    }
    else
    {
        if (processId == num_procs - 1)
        {
            processVector = (double *)malloc((cantidad + diferencia) * sizeof(double));
        }
        else
        {
            processVector = (double *)malloc((cantidad) * sizeof(double));
        }
    }

    ierr = MPI_Bcast(&escalar, 1, MPI_DOUBLE, processMaster, MPI_COMM_WORLD);

    if (processId == processMaster)
    {
        num_rows = 0;
        for (i = 1; i <= num_procs - 1; i++)
        {
            dest = i;
            tag = num_rows;
            // Enviar una parte del vector a cada proceso
            desplazamiento = num_rows * trunc(length / num_procs + 1);
            int aEnviar;
            if (i == num_procs - 1)
            {
                aEnviar = cantidad + diferencia;
            }
            else
            {
                aEnviar = cantidad;
            }
            ierr = MPI_Send(vectorOfDoubles + desplazamiento, aEnviar, MPI_DOUBLE, dest, tag, MPI_COMM_WORLD);

            printf("Cantidad enviado a proceso %d:  %d\n", i, aEnviar);

            num_rows = num_rows + 1;
        }
        num_workers = num_procs - 1;

        for (;;)
        {
            double *intermediateVector;
            intermediateVector = (double *)malloc((cantidad + diferencia) * sizeof(double));
            ierr = MPI_Recv(intermediateVector, cantidad + diferencia, MPI_DOUBLE, MPI_ANY_SOURCE,
                            MPI_ANY_TAG, MPI_COMM_WORLD, &status);

            // printf("Recibi una respuesta\n");

            num_workers = num_workers - 1;
            dest = status.MPI_SOURCE;
            tag = status.MPI_TAG;
            int aCompletar;
            int desp = (dest - 1) * trunc(length / num_procs + 1);
            if (dest == num_procs - 1)
            {
                aCompletar = cantidad + diferencia;
            }
            else
            {
                aCompletar = cantidad;
            }

            int lm = 0;
            printf("Destino: %d, Desplazamiento: %d, cantidad: %d\n", dest, desp, aCompletar);
            for (i = desp; i < desp + aCompletar; i++)
            {
                // printf("%d %f\n", i, intermediateVector[lm]);
                vectorOfDoubles[i] = intermediateVector[lm];
                lm++;
                // printf("%d %f\n", i, vectorOfDoubles[i]);
            }

            if (num_workers == 0)
            {
                break;
            }
        }
    }
    else
    {

        int aRecibir;
        if (processId == num_procs - 1)
        {
            aRecibir = cantidad + diferencia;
        }
        else
        {
            aRecibir = cantidad;
        }

        ierr = MPI_Recv(processVector, aRecibir, MPI_DOUBLE, processMaster, MPI_ANY_TAG,
                        MPI_COMM_WORLD, &status);

        tag = status.MPI_TAG;

        int z;
        for (z = 0; z < aRecibir; z++) // Multiplica cada elemento del vector por un escalar
        {
            processVector[z] = processVector[z] * escalar;
        }

        ierr = MPI_Send(processVector, aRecibir, MPI_DOUBLE, processMaster, tag, MPI_COMM_WORLD);

        free(processVector);
    }

    if (processId == processMaster)
    {
        printf("\n");
        printf("MATVEC - Master process:\n");
        printf("  Producto vector por un escalar:\n");
        printf("\n");
        for (i = 0; i < length; i++)
        {
            printf("%d %f\n", i, vectorOfDoubles[i]);
        }

        free(vectorOfDoubles);
    }

    ierr = MPI_Finalize();

    if (processId == processMaster)
    {
        printf("\n");
        printf("MATVEC - Master process:\n");
        printf("  Normal end of execution.\n");
        printf("\n");
        timestamp();
    }

    return 0;
}

void timestamp()
{
#define TIME_SIZE 40

    static char time_buffer[TIME_SIZE];
    const struct tm *tm;
    time_t now;

    now = time(NULL);
    tm = localtime(&now);

    strftime(time_buffer, TIME_SIZE, "%d %B %Y %I:%M:%S %p", tm);

    printf("%s\n", time_buffer);

    return;
#undef TIME_SIZE
}