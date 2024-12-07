package cl.inacap.neighborhoodcrimewatch;

import android.Manifest;
import android.annotation.SuppressLint;
import android.content.SharedPreferences;
import android.content.pm.PackageManager;
import android.location.Location;
import android.media.MediaPlayer;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.app.ActivityCompat;
import androidx.core.content.ContextCompat;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonObjectRequest;
import com.android.volley.toolbox.Volley;
import com.google.android.gms.location.FusedLocationProviderClient;
import com.google.android.gms.location.LocationServices;
import com.google.android.gms.tasks.OnSuccessListener;

import org.json.JSONException;
import org.json.JSONObject;

import java.io.OutputStream;
import java.io.UnsupportedEncodingException;
import java.net.HttpURLConnection;
import java.net.URL;
import java.net.URLEncoder;

public class Reporte extends AppCompatActivity {
    EditText descripcion, ubicacion; // Campos para la descripción y ubicación del incidente
    Button btnRegistrar; // Botón para registrar el incidente
    RequestQueue datos;

    @SuppressLint("MissingInflatedId")
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_reporte);

        // Inicializar los campos y el botón
        descripcion = findViewById(R.id.etDescripcion);
        ubicacion = findViewById(R.id.etDireccion);
        btnRegistrar = findViewById(R.id.btnAlarma);

        // Inicializar RequestQueue
        datos = Volley.newRequestQueue(this);

        // Configurar el botón de registro
        btnRegistrar.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                registrarIncidente();
            }
        });
    }

    private void registrarIncidente() {
        String descripcionInput = descripcion.getText().toString().trim();
        String ubicacionInput = ubicacion.getText().toString().trim();
        String idUsuario = obtenerIdUsuario();

        if (descripcionInput.isEmpty() || ubicacionInput.isEmpty()) {
            Toast.makeText(Reporte.this, "Por favor, complete todos los campos", Toast.LENGTH_SHORT).show();
            return;
        }

        String url = "http://54.173.43.72/registrarIncidente.php";

        JSONObject jsonBody = new JSONObject();
        try {
            jsonBody.put("descripcion", descripcionInput);
            jsonBody.put("ubicacion", ubicacionInput);
            jsonBody.put("idusuario", idUsuario);
        } catch (JSONException e) {
            e.printStackTrace();
            Toast.makeText(Reporte.this, "Error al crear el JSON", Toast.LENGTH_SHORT).show();
            return;
        }

        JsonObjectRequest jsonObjectRequest = new JsonObjectRequest(Request.Method.POST, url, jsonBody,
                new Response.Listener<JSONObject>() {
                    @Override
                    public void onResponse(JSONObject response) {
                        try {
                            String estado = response.getString("estado");
                            if (estado.equals("1")) {
                                Toast.makeText(Reporte.this, "Reporte registrado exitosamente", Toast.LENGTH_SHORT).show();
                            } else {
                                Toast.makeText(Reporte.this, response.getString("mensaje"), Toast.LENGTH_SHORT).show();
                            }
                        } catch (JSONException e) {
                            e.printStackTrace();
                        }
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        Toast.makeText(Reporte.this, "Error de conexión", Toast.LENGTH_SHORT).show();
                    }
                });

        datos.add(jsonObjectRequest);
    }

    private String obtenerIdUsuario() {
        SharedPreferences sharedPreferences = getSharedPreferences("mi_app", MODE_PRIVATE);
        String idUsuario = sharedPreferences.getString("idusu", null);
        Log.d("Reporte", "ID de usuario: " + idUsuario); // Agregar un log para depuración
        return idUsuario; // Recuperar el ID del usuario
    }
}