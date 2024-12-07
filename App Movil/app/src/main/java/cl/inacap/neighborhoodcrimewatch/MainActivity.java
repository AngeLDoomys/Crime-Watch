package cl.inacap.neighborhoodcrimewatch;

import static android.content.ContentValues.TAG;

import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonObjectRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONException;
import org.json.JSONObject;

public class MainActivity extends AppCompatActivity {
    EditText usuario, password;
    Button ingresar, registro;
    RequestQueue datos;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        // Inicializar las vistas
        usuario = findViewById(R.id.etEmail);
        password = findViewById(R.id.editTextTextPassword);
        ingresar = findViewById(R.id.btnLogin);
        registro = findViewById(R.id.btnRegistrarse);

        // Inicializar RequestQueue
        datos = Volley.newRequestQueue(this);


        // Configurar los listeners para los botones
        configurarBotones();
    }


    private void configurarBotones() {
        ingresar.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                String userInput = usuario.getText().toString().trim();
                String passwordInput = password.getText().toString().trim();

                // Validar que los campos no estén vacíos
                if (userInput.isEmpty() || passwordInput.isEmpty()) {
                    Toast.makeText(MainActivity.this, "Por favor, complete todos los campos", Toast.LENGTH_SHORT).show();
                } else {
                    consultardatos(userInput, passwordInput);
                }
            }
        });

        registro.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intentRegistro = new Intent(MainActivity.this, Registro.class);
                startActivity(intentRegistro);
            }
        });
    }

    public void consultardatos(String userInput, String passwordInput) {
        String url = "http://54.173.43.72/consultadatos.php?usu=" + userInput + "&pass=" + passwordInput;
        Log.d("URL", url); // Para verificar que la URL es correcta

        JsonObjectRequest request = new JsonObjectRequest(Request.Method.GET, url, null,
                new Response.Listener<JSONObject>() {
                    @Override
                    public void onResponse(JSONObject response) {
                        try {
                            String estado = response.getString("estado");
                            if (estado.equals("0")) {
                                Toast.makeText(MainActivity.this, "Usuario no Existe", Toast.LENGTH_LONG).show();
                            } else {
                                Intent ventana = new Intent(MainActivity.this, Home.class);
                                startActivity(ventana);
                                finish(); // Cerrar MainActivity
                            }
                        } catch (JSONException e) {
                            Toast.makeText(MainActivity.this, "Error en la respuesta del servidor", Toast.LENGTH_LONG).show();
                            e.printStackTrace();
                        }
                    }
                }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Toast.makeText(MainActivity.this, "Error de conexión. Intenta más tarde.", Toast.LENGTH_LONG).show();
                error.printStackTrace();
            }
        });

        datos.add(request);
    }
}